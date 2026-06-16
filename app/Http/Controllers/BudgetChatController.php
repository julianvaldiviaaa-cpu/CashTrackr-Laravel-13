<?php

namespace App\Http\Controllers;

use App\Ai\Agents\BudgetAssistant;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware("auth")]
#[Middleware("verified")]
class BudgetChatController extends Controller
{
    public function store(Request $request, Budget $budget)
    {
        $messages = collect($request->input("messages", []));

        // Extraer texto de cada mensaje (formato Vercel AI SDK)
        $history = $messages->map(function ($msg) {
            $text = collect(data_get($msg, "parts", []))
                ->where("type", "text")
                ->pluck("text")
                ->implode(" ");

            if (empty($text)) {
                $text = data_get($msg, "content", "");
            }

            return [
                "role"    => $msg["role"], // "user" | "assistant"
                "content" => trim($text),
            ];
        })->filter(fn($m) => !empty($m["content"]))->values()->toArray();

        // El último mensaje es el prompt actual
        $lastMessage = collect($history)->last();
        $prompt = $lastMessage["content"] ?? "";

        // El historial son todos los mensajes MENOS el último
        $previousHistory = array_slice($history, 0, -1);

        $agent = new BudgetAssistant;
        $agent->budgetId      = $budget->id;
        $agent->hasCategories = $budget->isGeneral();
        $agent->history       = $previousHistory; // ← aquí se inyecta la memoria

        $spent     = $budget->expenses()->sum("amount");
        $available = $budget->amount - $spent;

        if ($budget->isGoal()) {
            $agent->budgetContext = "Este presupuesto es de tipo Meta/Objetivo llamado '{$budget->name}' con un monto total de \${$budget->amount}. Gastado: \${$spent}. Disponible: \${$available}. Los gastos NO tienen categorías.";
        } else {
            $agent->budgetContext = "Este presupuesto es de tipo General llamado '{$budget->name}' con un monto total de \${$budget->amount}. Gastado: \${$spent}. Disponible: \${$available}. Los gastos tienen nombre, monto y categoría.";
        }

        return $agent->stream(
            $prompt,
            provider: "openrouter",
            model: "poolside/laguna-xs.2:free"
        )->usingVercelDataProtocol();
    }
}