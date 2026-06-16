import { Subscription } from "@/Types/Subscription";
import { formatDate } from "@/Utils";

type Props = {
    next_billing_date: Subscription["next_billing_date"];
    ends_at: Subscription["ends_at"];
};

export default function SubscriptionDowngrade({
    next_billing_date,
    ends_at,
}: Props) {
    return (
        <div className="rounded-2xl border border-purple-secondary/20 bg-purple-secondary/[0.04] p-5">
            <div className="flex items-start gap-3">
                <span className="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-secondary/15 border border-purple-secondary/20 flex items-center justify-center text-base">
                    📅
                </span>
                <div>
                    <h3 className="text-white font-semibold text-sm mb-0.5">
                        Estás en el plan Anual
                    </h3>
                    <p className="text-white/40 text-xs leading-relaxed">
                        Para cambiar a mensual, cancela tu suscripción actual.
                        Mantendrás acceso hasta el{" "}
                        <span className="text-white/60 font-medium">
                            {formatDate(ends_at || next_billing_date)}
                        </span>{" "}
                        y podrás suscribirte al plan mensual después.
                    </p>
                </div>
            </div>
        </div>
    );
}
