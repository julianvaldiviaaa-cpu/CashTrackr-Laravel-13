import { formatCurrency } from "@/Utils";

type AmountDisplayProps = {
    label: string;
    amount: number;
    variant?: "default" | "success" | "danger";
};

export default function AmountDisplay({
    label,
    amount,
    variant = "default",
}: AmountDisplayProps) {
    const amountColors = {
        default: "text-amber-400 font-black",
        success: "text-emerald-400 font-bold",
        danger: "text-rose-400 font-bold",
    };

    return (
        // flex-col e items-start fijos para que nunca se intenten alinear de lado
        <div className="flex flex-col items-start gap-1 w-full py-2 border-b border-white/5">
            <span className="text-xs uppercase tracking-widest text-gray-400 font-semibold block select-none">
                {label}
            </span>
            <span
                className={`text-xl sm:text-2xl lg:text-3xl font-black tabular-nums tracking-tight leading-none ${amountColors[variant]} block w-full`}
            >
                {formatCurrency(amount)}
            </span>
        </div>
    );
}
