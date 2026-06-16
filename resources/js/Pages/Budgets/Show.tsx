import {Budget} from "@/Types/budget";
import {usePage} from "@inertiajs/react";
import AmountDisplay from "@/Components/AmountDisplay";
import ExpenseModal from "@/Components/ExpenseModal";
import {useExpenseModalStore} from "@/Stores/expense-modal-store";
import {Category} from "@/Types/category";
import {useEffect, useState} from "react";
import {toast} from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import {formatCurrency, formatDate} from "@/Utils";
import Progressbar from "@/Components/Progressbar";
import ExpenseDropdown from "@/Components/ExpenseDropdown";
import DeleteExpenseModal from "@/Components/DeleteExpenseModal";
import CashTrackrAgent from "@/Components/CashTrackrAgent";
import PricingTable from "@/Components/PricingTable";
import {route} from "ziggy-js";
import ExpenseList from "@/Components/ExpenseList";
import AppLayout from "@/Layouts/AppLayout";

type Props = {
    budget: Budget;
    categories: Category[];
    spent: string;
};

export default function Show({budget, categories, spent}: Props) {
    const {flash, user} = usePage().props;
    const {openCreateModal} = useExpenseModalStore();

    useEffect(() => {
        useExpenseModalStore.getState().setBudget(budget);
        useExpenseModalStore.getState().setCategories(categories);
    }, [budget, categories]);

    useEffect(() => {
        if (flash.success) {
            toast.success(flash.success);
        }
    }, [flash]);

    const [progress, setProgress] = useState(0);
    const percentageUsed = +((+spent / +budget.amount) * 100).toFixed(2);

    useEffect(() => {
        const timeout = setTimeout(() => {
            setProgress(percentageUsed);
        }, 500);

        return () => clearTimeout(timeout);
    }, [percentageUsed]);

    const remaining = +budget.amount - +spent;

    return (
        <AppLayout title={`Presupuesto: ${budget.name}`}>
            <section className="mt-10">
                <div className="sm:flex-auto">
                    <h1 className="font-bold text-center flex flex-col items-center gap-1">
                        <span className="text-xl md:text-2xl uppercase tracking-widest text-gray-400 font-semibold">
                            Presupuesto
                        </span>
                        <span
                            className="text-4xl md:text-6xl lg:text-7xl tracking-tighter text-purple-secondary break-words max-w-4xl px-4">
                            {budget.name}
                        </span>
                    </h1>
                    <p className="mt-4 max-w-xl text-center text-lg md:text-xl text-gray-400 mx-auto leading-relaxed">
                        Controla tu presupuesto, añade tus gastos y edita cada
                        detalle.
                        <br/>
                        Nadie más que tú podrá acceder a este espacio.
                    </p>
                </div>
                <div className="mt-8 flex flex-col gap-4 lg:mt-12 lg:grid lg:grid-cols-2">
                    <a
                        href={"/dashboard"}
                        className="block bg-purple-principal hover:bg-purple-principal-hover transition-all duration-300 text-white px-5 py-3 rounded-lg font-bold text-xl cursor-pointer text-center shadow-sm"
                    >
                        Volver a Presupuestos
                    </a>

                    <a
                        href={route("budgets.edit", budget.id)}
                        className="block text-purple-principal px-5 py-3 rounded-lg font-bold border-2 border-purple-secondary bg-purple-secondary hover:bg-purple-secondary-hover transition-all duration-300 text-xl cursor-pointer text-center shadow-sm"
                    >
                        Editar este Presupuesto
                    </a>
                </div>
            </section>

            {/* MAIN PRINCIPAL RESPONSIVO */}
            <main className="flex flex-col gap-10 mt-16 lg:grid lg:grid-cols-12 lg:items-center lg:gap-12">
                {/* Columna de la Barra de Progreso: Toma 5 columnas de 12 en desktop */}
                <div className="flex justify-center items-center w-full lg:col-span-5">
                    {/* Forzamos el color del texto central pasándolo si tu componente lo acepta, u optimizándolo internamente */}
                    <Progressbar percentageUsed={progress}/>
                </div>

                {/* Columna de Tarjetas Financieras: Toma 7 columnas de 12 en desktop para tener más espacio */}
                <div
                    className="w-full bg-purple-principal/10 backdrop-blur-md border border-white/5 p-8 rounded-2xl flex flex-col sm:grid sm:grid-cols-3 lg:flex lg:flex-col gap-6 shadow-xl lg:col-span-7">
                    <AmountDisplay
                        label="Presupuesto"
                        amount={+budget.amount}
                        variant="default"
                    />
                    <AmountDisplay
                        label="Gastado"
                        amount={+spent}
                        variant="danger"
                    />
                    <AmountDisplay
                        label="Restante"
                        amount={remaining}
                        variant={remaining < 0 ? "danger" : "success"}
                    />
                </div>
            </main>

            {/* SECCIÓN DE GASTOS */}
            <section className="p-10 lg:px-5 shadow-lg mt-16 border border-white/5 rounded-2xl bg-black">
                <div className="flex items-center justify-between">
                    <h2 className="text-3xl font-bold text-white">Gastos</h2>

                    <button
                        onClick={openCreateModal}
                        className="bg-purple-principal hover:bg-purple-principal-hover transition-all duration-300 px-5 py-2 rounded-lg text-white font-bold text-xl cursor-pointer"
                    >
                        Nuevo Gasto
                    </button>
                </div>

                <ExpenseList
                    expenses={budget.expenses}
                    budgetType={budget.type}
                    formatCurrency={formatCurrency}
                    formatDate={formatDate}
                    openCreateModal={openCreateModal}
                />
            </section>

            {user.subscribed ? (
                <CashTrackrAgent budgetId={budget.id} name={user.user.name}/>
            ) : (
                <div className="mt-10">
                    <PricingTable/>
                </div>
            )}

            <ExpenseModal/>
            <DeleteExpenseModal/>
        </AppLayout>
    );
}
