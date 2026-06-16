import { Subscription } from "@/Types/Subscription";
import { formatDate } from "@/Utils";

type Props = {
    isYearly: boolean;
    color: string;
    status_label: Subscription["status_label"];
    price: Subscription["price"];
};

export default function SubscriptionStatus({
    isYearly,
    color,
    status_label,
    price,
}: Props) {
    return (
        <div className="rounded-2xl border border-white/[0.06] bg-white/[0.02] p-5 mb-4">
            <div className="flex items-start justify-between gap-4 mb-4">
                <div>
                    <p className="text-white/30 text-xs font-medium tracking-widest uppercase mb-1.5">
                        Plan actual
                    </p>
                    <div className="flex items-center gap-2">
                        <span className="text-white font-bold text-lg tracking-tight">
                            PRO {isYearly ? "Anual" : "Mensual"}
                        </span>
                        {isYearly && (
                            <span className="px-2 py-0.5 rounded-md bg-amber-500/15 border border-amber-500/25 text-amber-400 text-[10px] font-semibold tracking-wide">
                                ✦ MEJOR VALOR
                            </span>
                        )}
                    </div>
                </div>
                <div className="text-right flex-shrink-0">
                    <p className="text-white font-bold text-2xl tabular-nums tracking-tight">
                        ${price}
                    </p>
                    <p className="text-white/30 text-xs">
                        / {isYearly ? "año" : "mes"}
                    </p>
                </div>
            </div>

            <div className={`rounded-xl border p-3.5 ${color}`}>
                <p className="font-semibold text-sm mb-0.5">
                    {status_label.text}
                </p>
                {status_label.date ? (
                    <p className="text-sm opacity-80">
                        {status_label.description}{" "}
                        <span className="font-medium">
                            {formatDate(status_label.date)}
                        </span>
                    </p>
                ) : (
                    <p className="text-sm opacity-80">
                        {status_label.description}
                    </p>
                )}
            </div>
        </div>
    );
}
