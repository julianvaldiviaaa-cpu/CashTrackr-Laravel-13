import React, { useRef, useState, useEffect } from "react";
import { useChat } from "@ai-sdk/react";
import { DefaultChatTransport } from "ai";
import { toast } from "react-toastify";
import { router } from "@inertiajs/react";

type Props = {
    budgetId: number;
    name: string;
    budgetName?: string;
    available?: number;
    total?: number;
};

function renderMarkdown(text: string) {
    const parts = text.split(/(\*\*.*?\*\*)/g);
    return parts.map((part, i) => {
        if (part.startsWith("**") && part.endsWith("**")) {
            return (
                <strong key={i} className="font-medium text-white">
                    {part.slice(2, -2)}
                </strong>
            );
        }
        return part;
    });
}

const CHIPS = [
    { label: "¿Cuánto llevo gastado?", icon: "💸" },
    { label: "¿Dónde gasto más?", icon: "📊" },
    { label: "¿Me alcanza el mes?", icon: "📅" },
    { label: "Últimos gastos", icon: "🧾" },
    { label: "Gasto más caro", icon: "🏆" },
];

function TypingDots() {
    return (
        <div className="flex items-center gap-1 px-1 py-0.5">
            {[0, 1, 2].map((i) => (
                <span
                    key={i}
                    className="block w-1.5 h-1.5 rounded-full bg-white/40 animate-bounce"
                    style={{
                        animationDelay: `${i * 0.15}s`,
                        animationDuration: "0.9s",
                    }}
                />
            ))}
        </div>
    );
}

export default function CashTrackrAgent({
    budgetId,
    name,
    budgetName = "Mi Presupuesto",
    available = 0,
    total = 0,
}: Props) {
    const [input, setInput] = useState("");
    const fileInputRef = useRef<HTMLInputElement>(null);
    const messagesEndRef = useRef<HTMLDivElement>(null);
    const textareaRef = useRef<HTMLTextAreaElement>(null);

    const { sendMessage, messages, setMessages, status } = useChat({
        transport: new DefaultChatTransport({
            api: `/dashboard/budgets/${budgetId}/chat`,
        }),
        onFinish: ({ message }) => {
            const expenseCreated = message.parts.some((part) => {
                const isAddedExpenseTool = part.type === "tool-AddExpense";
                const finished =
                    "state" in part && part.state === "output-available";
                return isAddedExpenseTool && finished;
            });
            if (expenseCreated) {
                toast.success("Gasto agregado correctamente");
                router.reload();
            }
        },
    });

    const isBusy = status === "streaming" || status === "submitted";
    const pct =
        total > 0
            ? Math.min(100, Math.round(((total - available) / total) * 100))
            : 0;

    useEffect(() => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    }, [messages, status]);

    const handleSend = () => {
        const text = input.trim();
        if (!text || isBusy) return;
        sendMessage({ text });
        setInput("");
        if (textareaRef.current) textareaRef.current.style.height = "auto";
    };

    const handleKeyDown = (e: React.KeyboardEvent<HTMLTextAreaElement>) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    const handleTextareaChange = (
        e: React.ChangeEvent<HTMLTextAreaElement>,
    ) => {
        setInput(e.target.value);
        e.target.style.height = "auto";
        e.target.style.height = Math.min(e.target.scrollHeight, 160) + "px";
    };

    const handleChip = (label: string) => {
        if (isBusy) return;
        sendMessage({ text: label });
    };

    const handleImageUpload = async (
        e: React.ChangeEvent<HTMLInputElement>,
    ) => {
        const file = e.target.files?.[0];
        if (!file) return;

        setMessages((prev) => [
            ...prev,
            {
                id: crypto.randomUUID(),
                role: "user" as const,
                content: "Ticket de compra subido",
                parts: [
                    { type: "text" as const, text: "Ticket de compra subido" },
                ],
            },
        ]);

        try {
            const csrfToken =
                document.querySelector<HTMLMetaElement>(
                    'meta[name="csrf-token"]',
                )?.content ?? "";
            const formData = new FormData();
            formData.append("image", file);

            const response = await fetch(
                `/dashboard/budgets/${budgetId}/scan-ticket`,
                {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                    credentials: "same-origin",
                    body: formData,
                },
            );

            const data = await response.json();

            setMessages((prev) => [
                ...prev,
                {
                    id: crypto.randomUUID(),
                    role: "assistant" as const,
                    content: data.message,
                    parts: [{ type: "text" as const, text: data.message }],
                },
            ]);
            if (data.success) {
                toast.success("Gastos del ticket registrados");
                router.reload();
            }
        } catch {
            setMessages((prev) => [
                ...prev,
                {
                    id: crypto.randomUUID(),
                    role: "assistant" as const,
                    content: "Error al procesar el ticket, intenta de nuevo.",
                    parts: [
                        {
                            type: "text" as const,
                            text: "Error al procesar el ticket, intenta de nuevo.",
                        },
                    ],
                },
            ]);
        } finally {
            if (fileInputRef.current) fileInputRef.current.value = "";
        }
    };

    const isEmpty = messages.length === 0;

    return (
        <section className="mt-16 rounded-2xl overflow-hidden border border-white/[0.06] bg-[#0A0A0F]">
            {/* ── HEADER ── */}
            <div className="px-6 pt-6 pb-5 border-b border-white/[0.06]">
                <div className="flex items-start justify-between gap-4">
                    <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-purple-principal flex items-center justify-center flex-shrink-0">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="white"
                                strokeWidth="1.8"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <path d="M12 2a9 9 0 0 1 9 9c0 3.6-2.1 6.7-5.1 8.2L15 21H9l-.9-1.8A9 9 0 0 1 12 2Z" />
                                <path d="M9 12h.01M12 12h.01M15 12h.01" />
                            </svg>
                        </div>
                        <div>
                            <p className="text-white font-medium text-sm leading-none mb-1">
                                CashTrackr IA
                            </p>
                            <p className="text-white/40 text-xs">
                                {budgetName}
                            </p>
                        </div>
                    </div>

                    {total > 0 && (
                        <div className="text-right flex-shrink-0">
                            <p className="text-white/40 text-xs mb-1">
                                Disponible
                            </p>
                            <p className="text-white font-medium text-sm">
                                ${available.toLocaleString("es-MX")}
                                <span className="text-white/30 font-normal">
                                    {" "}
                                    / ${total.toLocaleString("es-MX")}
                                </span>
                            </p>
                        </div>
                    )}
                </div>

                {total > 0 && (
                    <div className="mt-4">
                        <div className="flex justify-between text-xs text-white/30 mb-1.5">
                            <span>Gastado</span>
                            <span>{pct}%</span>
                        </div>
                        <div className="h-1 w-full bg-white/[0.06] rounded-full overflow-hidden">
                            <div
                                className="h-full rounded-full transition-all duration-700"
                                style={{
                                    width: `${pct}%`,
                                    backgroundColor:
                                        pct >= 90
                                            ? "#E24B4A"
                                            : pct >= 70
                                              ? "#BA7517"
                                              : "#36255C",
                                }}
                            />
                        </div>
                    </div>
                )}
            </div>

            {/* ── MESSAGES ── */}
            <div
                className="px-4 py-5 min-h-[320px] max-h-[480px] overflow-y-auto flex flex-col gap-3 scroll-smooth"
                style={{
                    scrollbarWidth: "thin",
                    scrollbarColor: "rgba(255,255,255,0.08) transparent",
                }}
            >
                {isEmpty && (
                    <div className="flex flex-col items-center justify-center h-48 gap-3">
                        <div className="w-12 h-12 rounded-2xl bg-purple-principal/20 flex items-center justify-center">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#7F77DD"
                                strokeWidth="1.6"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <div className="text-center">
                            <p className="text-white/60 text-sm font-medium">
                                ¿Qué quieres saber, {name}?
                            </p>
                            <p className="text-white/25 text-xs mt-0.5">
                                Pregunta sobre tus gastos o agrega uno nuevo
                            </p>
                        </div>
                    </div>
                )}

                {messages.map((m) => {
                    const isUser = m.role === "user";
                    const textParts = m.parts.filter((p) => p.type === "text");

                    return (
                        <div
                            key={m.id}
                            className={`flex ${isUser ? "justify-end" : "justify-start"}`}
                        >
                            <div
                                className={`flex flex-col gap-1 max-w-[80%] lg:max-w-[68%] ${isUser ? "items-end" : "items-start"}`}
                            >
                                <span className="text-[10px] font-medium tracking-widest uppercase text-white/25 px-1">
                                    {isUser ? name : "CashTrackr IA"}
                                </span>
                                <div
                                    className={`px-4 py-3 text-sm leading-relaxed ${
                                        isUser
                                            ? "bg-purple-principal text-white rounded-2xl rounded-br-sm"
                                            : "bg-white/[0.05] text-white/85 rounded-2xl rounded-bl-sm border border-white/[0.06]"
                                    }`}
                                >
                                    {textParts.map((part, i) => {
                                        if (part.type !== "text") return null;
                                        const text = part.text
                                            .replace("[EXPENSE_CREATED]", "")
                                            .trim();
                                        if (!text) return null;
                                        return (
                                            <p
                                                key={i}
                                                className="whitespace-pre-wrap"
                                            >
                                                {isUser
                                                    ? text
                                                    : renderMarkdown(text)}
                                            </p>
                                        );
                                    })}
                                </div>
                            </div>
                        </div>
                    );
                })}

                {isBusy && (
                    <div className="flex justify-start">
                        <div className="flex flex-col gap-1 items-start">
                            <span className="text-[10px] font-medium tracking-widest uppercase text-white/25 px-1">
                                CashTrackr IA
                            </span>
                            <div className="bg-white/[0.05] border border-white/[0.06] rounded-2xl rounded-bl-sm px-4 py-3">
                                <TypingDots />
                            </div>
                        </div>
                    </div>
                )}

                <div ref={messagesEndRef} />
            </div>

            {/* ── CHIPS ── */}
            {isEmpty && (
                <div className="px-4 pb-3 flex flex-wrap gap-2">
                    {CHIPS.map(({ label, icon }) => (
                        <button
                            key={label}
                            onClick={() => handleChip(label)}
                            disabled={isBusy}
                            className="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs text-white/50 border border-white/[0.08] bg-white/[0.02] hover:bg-white/[0.06] hover:text-white/80 hover:border-white/[0.15] transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed"
                        >
                            <span>{icon}</span>
                            {label}
                        </button>
                    ))}
                </div>
            )}

            {/* ── INPUT ── */}
            <div className="px-4 pb-4 border-t border-white/[0.06] pt-4">
                <div className="flex items-end gap-2 bg-white/[0.03] border border-white/[0.08] rounded-2xl px-4 py-3 focus-within:border-purple-principal/50 focus-within:bg-white/[0.05] transition-all duration-200">
                    <textarea
                        ref={textareaRef}
                        value={input}
                        onChange={handleTextareaChange}
                        onKeyDown={handleKeyDown}
                        placeholder="Escribe en lenguaje natural..."
                        rows={1}
                        disabled={isBusy}
                        className="flex-1 bg-transparent text-white/90 text-sm placeholder-white/20 resize-none outline-none leading-relaxed min-h-[24px] max-h-[160px] overflow-y-auto disabled:opacity-40"
                        style={{ scrollbarWidth: "none" }}
                    />

                    <div className="flex items-center gap-2 flex-shrink-0 pb-0.5">
                        <button
                            type="button"
                            onClick={() => fileInputRef.current?.click()}
                            disabled={isBusy}
                            title="Subir ticket"
                            className="w-8 h-8 rounded-xl flex items-center justify-center text-white/30 hover:text-amber-400 hover:bg-amber-400/10 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed"
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="1.8"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                <polyline points="14,2 14,8 20,8" />
                                <line x1="12" y1="18" x2="12" y2="12" />
                                <line x1="9" y1="15" x2="15" y2="15" />
                            </svg>
                        </button>

                        <button
                            type="button"
                            onClick={handleSend}
                            disabled={isBusy || !input.trim()}
                            className="w-8 h-8 rounded-xl bg-purple-principal flex items-center justify-center text-white hover:bg-purple-principal-hover transition-all duration-200 disabled:opacity-25 disabled:cursor-not-allowed"
                        >
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2.2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22,2 15,22 11,13 2,9" />
                            </svg>
                        </button>
                    </div>
                </div>

                <p className="text-center text-[10px] text-white/15 mt-2 tracking-wide">
                    Enter para enviar · Shift+Enter para nueva línea · Sube un
                    ticket con <span className="text-amber-400/50">📄</span>
                </p>
            </div>

            <input
                type="file"
                accept="image/*"
                className="hidden"
                ref={fileInputRef}
                onChange={handleImageUpload}
            />
        </section>
    );
}
