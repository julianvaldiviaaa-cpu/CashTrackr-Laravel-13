import { Expense } from "@/Types/expense";
import { useExpenseModalStore } from "@/Stores/expense-modal-store";
import { useDeleteExpenseStore } from "@/Stores/expense-delete-store";

type Props = {
    expenses: Expense[];
    budgetType: "general" | "goal";
    formatCurrency: (amount: number) => string;
    formatDate: (date: string | null) => string | undefined;
    openCreateModal: () => void;
};

const CATEGORY_ICONS: Record<string, string> = {
    food: "🛒",
    transportation: "🚗",
    health: "🏥",
    entertainment: "🎬",
    subscriptions: "📦",
    beauty: "💄",
    clothing: "👗",
    home: "🏠",
    education: "📚",
    pets: "🐾",
    other: "📌",
};

function ExpenseRow({
    expense,
    budgetType,
    formatCurrency,
    formatDate,
}: {
    expense: Expense;
    budgetType: "general" | "goal";
    formatCurrency: (n: number) => string;
    formatDate: (d: string | null) => string | undefined;
}) {
    const { openEditModal } = useExpenseModalStore();
    const { openModal } = useDeleteExpenseStore();

    const icon = CATEGORY_ICONS[expense.category] ?? "📌";

    return (
        <li className="group flex items-center gap-3 px-4 py-3.5 hover:bg-white/[0.025] transition-colors duration-150">
            {/* Icon */}
            <div className="flex-shrink-0 w-9 h-9 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-base select-none">
                {icon}
            </div>

            {/* Main info — takes all available space */}
            <div className="flex-1 min-w-0">
                <div className="flex flex-col lg:flex-row items-start justify-between gap-2">
                    {/* Left: name + date */}
                    <div className="min-w-0 flex-1">
                        <p className="text-white font-medium text-sm lg:text-2xl truncate leading-snug">
                            {expense.name}
                        </p>
                        <p className="text-white/30 text-xs lg:text-sm mt-0.5 whitespace-nowrap">
                            {formatDate(expense.created_at) ?? "—"}
                        </p>
                    </div>

                    {/* Right: amount + action buttons */}
                    <div className="flex-shrink-0 flex items-center gap-1.5">
                        <p className="text-white font-medium text-sm lg:text-2xl tabular-nums whitespace-nowrap">
                            {formatCurrency(+expense.amount)}
                        </p>
                        <div className="flex items-center gap-0.5 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-150">
                            <button
                                type="button"
                                onClick={() => openEditModal(expense)}
                                title="Editar"
                                className="w-7 h-7 rounded-lg flex items-center justify-center text-white/30 hover:text-white hover:bg-white/[0.06] transition-all duration-150"
                            >
                                <svg
                                    width="13"
                                    height="13"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="1.8"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <button
                                type="button"
                                onClick={() => openModal(expense)}
                                title="Eliminar"
                                className="w-7 h-7 rounded-lg flex items-center justify-center text-white/30 hover:text-red-400 hover:bg-red-400/10 transition-all duration-150"
                            >
                                <svg
                                    width="13"
                                    height="13"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="1.8"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {/* Category badge on its own line */}
                {budgetType === "general" && (
                    <span
                        className={`inline-flex items-center mt-1.5 px-2 py-0.5 rounded-md text-[10px] font-medium tracking-wide ${expense.category_color}`}
                    >
                        {expense.category_label}
                    </span>
                )}
            </div>
        </li>
    );
}

export default function ExpenseList({
    expenses,
    budgetType,
    formatCurrency,
    formatDate,
    openCreateModal,
}: Props) {
    if (!expenses.length) {
        return (
            <div className="mt-8 flex flex-col items-center justify-center py-16 gap-3">
                <div className="text-center">
                    <p className="text-white/40 text-sm">
                        Sin gastos registrados
                    </p>
                    <button
                        type="button"
                        onClick={openCreateModal}
                        className="mt-1 text-amber-400 text-sm font-medium hover:text-amber-300 transition-colors"
                    >
                        Agrega el primero →
                    </button>
                </div>
            </div>
        );
    }

    const total = expenses.reduce((sum, e) => sum + +e.amount, 0);

    return (
        <div className="mt-8">
            <div className="flex items-center justify-between px-4 mb-2">
                <p className="text-white/30 text-xs font-medium tracking-widest uppercase">
                    {expenses.length}{" "}
                    {expenses.length === 1 ? "gasto" : "gastos"}
                </p>
                <p className="text-white/30 text-xs font-medium tabular-nums">
                    Total: {formatCurrency(total)}
                </p>
            </div>

            <ul className="rounded-xl border border-white/[0.06] bg-white/[0.02] overflow-hidden divide-y divide-white/[0.04]">
                {expenses.map((expense) => (
                    <ExpenseRow
                        key={expense.id}
                        expense={expense}
                        budgetType={budgetType}
                        formatCurrency={formatCurrency}
                        formatDate={formatDate}
                    />
                ))}
            </ul>
        </div>
    );
}
