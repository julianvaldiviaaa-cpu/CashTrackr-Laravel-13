import {useState} from "react";
import {Subscription} from "@/Types/Subscription";
import {formatDate} from "@/Utils";
import {router} from "@inertiajs/react";
import {route} from "ziggy-js";

type Props = {
    ends_at: Subscription["ends_at"];
};

export default function SubscriptionResume({ends_at}: Props) {
    const [loading, setLoading] = useState(false);

    const resumeSubscription = () => {
        setLoading(true);
        router.post(
            route("subscription.resume"),
            {},
            {
                onFinish: () => setLoading(false),
                preserveScroll: true,
            }
        );
    };

    return (
        <div className="rounded-2xl border border-purple-secondary/25 bg-purple-secondary/[0.05] p-5">
            <div className="flex items-start gap-3 mb-4">
                <span
                    className="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-secondary/15 border border-purple-secondary/20 flex items-center justify-center text-base">
                    💜
                </span>
                <div>
                    <h3 className="text-white font-semibold text-sm mb-0.5">
                        ¿Cambiaste de opinión?
                    </h3>
                    <p className="text-white/40 text-xs leading-relaxed">
                        Puedes reactivar tu suscripción antes del{" "}
                        <span className="text-white/60 font-medium">
                            {formatDate(ends_at)}
                        </span>{" "}
                        sin ningún cargo adicional.
                    </p>
                </div>
            </div>

            <button
                onClick={resumeSubscription}
                disabled={loading}
                className="w-full py-2.5 rounded-xl bg-purple-principal hover:bg-purple-principal-hover text-white font-medium text-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed shadow-lg shadow-purple-principal/20"
            >
                {loading ? (
                    <span className="flex items-center justify-center gap-2">
                        <span
                            className="w-3.5 h-3.5 rounded-full border-2 border-white/30 border-t-white animate-spin"/>
                        Procesando...
                    </span>
                ) : "Reactivar suscripción"}
            </button>
        </div>
    );
}
