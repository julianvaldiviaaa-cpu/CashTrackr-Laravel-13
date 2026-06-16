import {useState} from "react";
import {Subscription} from "@/Types/Subscription";
import {formatDate} from "@/Utils";
import {router} from "@inertiajs/react";
import {route} from "ziggy-js";

type Props = {
    next_billing_date: Subscription["next_billing_date"];
};

export default function SubscriptionCancellation({next_billing_date}: Props) {
    const [loading, setLoading] = useState(false);
    const [confirmCancel, setConfirmCancel] = useState(false);

    const cancelSubscription = () => {
        setLoading(true);
        router.post(
            route("subscription.cancel"),
            {},
            {
                onFinish: () => {
                    setLoading(false);
                    setConfirmCancel(false);
                },
                preserveScroll: true,
            },
        );
    };

    return (
        <div
            className={`rounded-2xl border p-5 transition-all duration-200 ${
                confirmCancel
                    ? "border-red-500/30 bg-red-500/[0.06]"
                    : "border-white/[0.06] bg-white/[0.02]"
            }`}
        >
            <div className="flex items-start gap-3 mb-4">
                <span
                    className="flex-shrink-0 w-8 h-8 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center text-base">
                    ⚠️
                </span>
                <div>
                    <h3 className="text-white font-semibold text-sm mb-0.5">
                        Cancelar suscripción
                    </h3>
                    <p className="text-white/40 text-xs leading-relaxed">
                        Mantendrás acceso hasta el{" "}
                        <span className="text-white/60 font-medium">
        {formatDate(next_billing_date)}
    </span>
                        . Sin más cobros después. <span className="text-white/60">Esta acción no reembolsará Esta acción no reembolsará</span>

                    </p>
                </div>
            </div>

            {!confirmCancel ? (
                <button
                    onClick={() => setConfirmCancel(true)}
                    className="w-full py-2.5 rounded-xl border border-red-500/25 text-red-400 text-sm font-medium hover:bg-red-500/10 transition-all duration-200"
                >
                    Cancelar mi suscripción
                </button>
            ) : (
                <div className="flex flex-col gap-2">
                    <p className="text-white/60 text-xs text-center mb-1">
                        ¿Confirmas que quieres cancelar?
                    </p>
                    <div className="flex gap-2">
                        <button
                            onClick={() => setConfirmCancel(false)}
                            disabled={loading}
                            className="flex-1 py-2.5 rounded-xl bg-white/[0.06] hover:bg-white/[0.1] border border-white/[0.08] text-white/70 text-sm font-medium transition-all duration-200 disabled:opacity-40"
                        >
                            No, mantener
                        </button>
                        <button
                            onClick={cancelSubscription}
                            disabled={loading}
                            className="flex-1 py-2.5 rounded-xl bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-400 text-sm font-medium transition-all duration-200 disabled:opacity-40"
                        >
                            {loading ? (
                                <span className="flex items-center justify-center gap-2">
                                    <span
                                        className="w-3.5 h-3.5 rounded-full border-2 border-red-400/30 border-t-red-400 animate-spin"/>
                                    Cancelando...
                                </span>
                            ) : (
                                "Sí, cancelar"
                            )}
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
