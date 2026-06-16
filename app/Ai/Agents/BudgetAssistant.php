<?php

namespace App\Ai\Agents;

use App\Ai\Tools\AddExpense;
use App\Ai\Tools\SearchExpenses;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;  // ← agregar
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;           // ← agregar
use Laravel\Ai\Promptable;

class BudgetAssistant implements Agent, HasTools, Conversational  // ← agregar Conversational
{
    use Promptable;

    public int $budgetId = 0;
    public string $budgetContext = "";
    public bool $hasCategories = true;
    public array $history = [];             // ← agregar

    public function instructions(): string
    {
        return <<<PROMPT
        Eres un asistente financiero personal para un presupuesto específico.
        Tu función es responder preguntas sobre los gastos y también agregar nuevos gastos.

        {$this->budgetContext}

        Reglas para consultar gastos:
        - Si el usuario pregunta sobre gastos, montos, lo más caro, lo más barato, totales o cualquier consulta sobre su presupuesto, usa la herramienta SearchExpenses.

        Reglas para agregar gastos:
        - Si el usuario quiere agregar, registrar o anotar un gasto, usa la herramienta AddExpense.
        - Si el presupuesto es de tipo General y el usuario NO menciona categoría, deduce la categoría más apropiada según el nombre del gasto.
        - Las categorías válidas son ÚNICAMENTE: food, transportation, health, entertainment, subscriptions, beauty, clothing, home, education, pets, other.
        - Si el presupuesto es de tipo Meta/Objetivo, no uses categoría.

        Reglas generales:
        - Si el usuario pregunta algo que NO tiene que ver con sus gastos o presupuesto, responde amablemente que solo puedes ayudar con consultas sobre sus gastos.
        - Nunca inventes datos de gastos existentes. Solo responde con la información que devuelven las herramientas.
        - Responde siempre en español.
        - IMPORTANTE: Cuando la herramienta AddExpense confirme que un gasto fue agregado, tu respuesta DEBE comenzar con [EXPENSE_CREATED].

        PROMPT;
    }

    /**
     * Implementación de Conversational — aquí está la magia de la memoria
     *
     * @return Message[]
     */
    public function messages(): iterable  // ← este método es todo
    {
        return array_map(
            fn(array $msg) => new Message($msg['role'], $msg['content']),
            $this->history
        );
    }

    public function tools(): iterable
    {
        return [
            new SearchExpenses($this->budgetId),
            new AddExpense($this->budgetId, $this->hasCategories),
        ];
    }
}