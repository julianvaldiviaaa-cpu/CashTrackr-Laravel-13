import { router } from "@inertiajs/react";
import { route } from "ziggy-js";
import { useState } from "react";

export default function SubscriptionUpgrade() {
    const [loading, setLoading] = useState(false);

    const swapPlan = () => {
        setLoading(true);
        router.post(
            route("subscription.swap", "yearly"),
            {},
            {
                onFinish: () => setLoading(false),
                preserveScroll: true,
            },
        );
    };

    return (
        <div className="rounded-2xl border border-amber-500/20 bg-amber-500/[0.04] p-5">
            <div className="flex items-start gap-3 mb-4">
                <span className="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-500/15 border border-amber-500/25 flex items-center justify-center text-base">
                    ⚡
                </span>
                <div>
                    <h3 className="text-white font-semibold text-sm mb-0.5">
                        Upgrade a Anual y ahorra $198
                    </h3>
                    <p className="text-white/40 text-xs leading-relaxed">
                        $999/año en lugar de $1,188 — equivale a 2 meses gratis.
                        Solo pagas la diferencia proporcional al tiempo restante
                        del mes.
                    </p>
                </div>
            </div>
            <button
                onClick={swapPlan}
                disabled={loading}
                className="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-white font-semibold text-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed"
            >
                {loading ? (
                    <span className="flex items-center justify-center gap-2">
                        <span className="w-3.5 h-3.5 rounded-full border-2 border-white/30 border-t-white animate-spin" />
                        Procesando...
                    </span>
                ) : (
                    "Cambiar a Anual →"
                )}
            </button>
        </div>
    );
}
