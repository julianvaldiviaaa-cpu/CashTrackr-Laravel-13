import { router } from "@inertiajs/react";
import { useState } from "react";
import { route } from "ziggy-js";

export default function PricingTable() {
    const [loading, setLoading] = useState<string | null>(null);

    const subscribe = (plan: "monthly" | "yearly") => {
        setLoading(plan);
        router.post(route("subscription.checkout", { plan }));
    };

    return (
        <div className="py-4">
            {/* Header */}
            <div className="max-w-2xl mx-auto text-center mb-12">
                <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-principal/15 border border-purple-principal/25 text-purple-secondary text-xs font-medium tracking-wide mb-4">
                    ✦ Plan Pro
                </span>
                <h2 className="text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                    Gestiona tus finanzas con{" "} <br />
                    <span className="text-transparent text-4xl lg:text-7xl capitalize bg-clip-text bg-gradient-to-r from-purple-secondary to-purple-principal">
                        inteligencia artificial
                    </span>
                </h2>
                <p className="mt-4 text-white/45 text-base leading-relaxed">
                    Conversa con tu asistente, sube tickets y deja que la IA
                    registre tus gastos automáticamente.
                </p>
            </div>

            {/* Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl mx-auto">
                {/* ── Monthly ── */}
                <div className="relative rounded-2xl border border-white/[0.07] bg-white/[0.02] p-6 flex flex-col">
                    <div className="mb-6">
                        <p className="text-white/40 text-xs font-medium tracking-widest uppercase mb-3">
                            Mensual
                        </p>
                        <div className="flex items-end gap-1">
                            <span className="text-5xl font-bold text-white tracking-tight">
                                $99
                            </span>
                            <span className="text-white/30 text-sm mb-1.5">
                                /mes
                            </span>
                        </div>
                    </div>

                    <ul className="flex flex-col gap-2.5 mb-8 flex-1">
                        {[
                            "Asistente IA ilimitado",
                            "Escaneo de tickets con cámara",
                            "Cancela cuando quieras",
                        ].map((feature) => (
                            <li
                                key={feature}
                                className="flex items-center gap-2.5 text-white/60 text-sm"
                            >
                                <span className="flex-shrink-0 w-4 h-4 rounded-full bg-white/[0.06] border border-white/[0.08] flex items-center justify-center">
                                    <svg
                                        width="8"
                                        height="8"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="3"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        className="text-white/50"
                                    >
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </span>
                                {feature}
                            </li>
                        ))}
                    </ul>

                    <button
                        onClick={() => subscribe("monthly")}
                        disabled={loading !== null}
                        className="w-full py-3 rounded-xl bg-white/[0.06] hover:bg-white/[0.1] border border-white/[0.08] text-white font-medium text-sm transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed"
                    >
                        {loading === "monthly" ? (
                            <span className="flex items-center justify-center gap-2">
                                <span className="w-3.5 h-3.5 rounded-full border-2 border-white/30 border-t-white animate-spin" />
                                Procesando...
                            </span>
                        ) : (
                            "Comenzar mensual"
                        )}
                    </button>
                </div>

                {/* ── Yearly (featured) ── */}
                <div className="relative rounded-2xl border border-purple-principal/40 bg-purple-principal/[0.06] p-6 flex flex-col">
                    {/* Badge */}
                    <div className="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-principal text-white text-[11px] font-semibold tracking-wide whitespace-nowrap shadow-lg shadow-purple-principal/30">
                            ✦ 2 meses gratis
                        </span>
                    </div>

                    <div className="mb-6 mt-2">
                        <p className="text-purple-secondary/70 text-xs font-medium tracking-widest uppercase mb-3">
                            Anual
                        </p>
                        <div className="flex items-end gap-1">
                            <span className="text-5xl font-bold text-white tracking-tight">
                                $999
                            </span>
                            <span className="text-white/30 text-sm mb-1.5">
                                /año
                            </span>
                        </div>
                        <p className="text-purple-secondary/60 text-xs mt-1.5 font-medium">
                            Equivale a $83.25/mes · Ahorras $189
                        </p>
                    </div>

                    <ul className="flex flex-col gap-2.5 mb-8 flex-1">
                        {[
                            "Todo lo del plan mensual",
                            "2 meses completamente gratis",
                            "Soporte prioritario",
                        ].map((feature) => (
                            <li
                                key={feature}
                                className="flex items-center gap-2.5 text-white/60 text-sm"
                            >
                                <span className="flex-shrink-0 w-4 h-4 rounded-full bg-purple-principal/20 border border-purple-principal/30 flex items-center justify-center">
                                    <svg
                                        width="8"
                                        height="8"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="3"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        className="text-purple-secondary"
                                    >
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </span>
                                {feature}
                            </li>
                        ))}
                    </ul>

                    <button
                        onClick={() => subscribe("yearly")}
                        disabled={loading !== null}
                        className="w-full py-3 rounded-xl bg-purple-principal hover:bg-purple-principal-hover text-white font-medium text-sm transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed shadow-lg shadow-purple-principal/25"
                    >
                        {loading === "yearly" ? (
                            <span className="flex items-center justify-center gap-2">
                                <span className="w-3.5 h-3.5 rounded-full border-2 border-white/30 border-t-white animate-spin" />
                                Procesando...
                            </span>
                        ) : (
                            "Comenzar anual"
                        )}
                    </button>
                </div>
            </div>

            {/* Footer note */}
            <p className="text-center text-white/20 text-xs mt-6">
                Pago seguro con Stripe · Cancela en cualquier momento · Sin
                contratos
            </p>
        </div>
    );
}
