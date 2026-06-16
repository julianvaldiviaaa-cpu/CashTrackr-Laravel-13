import {create} from "zustand";
import {Budget} from "@/Types/budget";
import {Category} from "@/Types/category";
import {Expense} from "@/Types/expense";

type ExpenseModalStore = {
    open: boolean,
    budget: Budget | null,
    expense: Expense | null,
    categories: Category[],
    openCreateModal: () => void
    openEditModal: (expense: Expense) => void
    closeModal: () => void,
    setBudget: (budget: Budget) => void,
    setCategories: (categories: Category[]) => void
}

export const useExpenseModalStore = create<ExpenseModalStore>((set) => ({
    open: false,
    budget: null,
    expense: null,
    categories: [],
    openCreateModal: () => {
        set({
            open: true
        })
    },
    openEditModal: (expense) => {
        set({
            open: true,
            expense
        })
    },
    closeModal: () => {
        set({
            open: false,
        })

        setTimeout(() => {
            set({expense: null})
        }, 500)
    },
    setBudget: (budget) => {
        set({
            budget
        })
    },
    setCategories: (categories) => {
        set({
            categories
        })
    }
}))
