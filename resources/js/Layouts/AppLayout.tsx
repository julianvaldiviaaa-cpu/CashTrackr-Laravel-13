import {toast, ToastContainer} from "react-toastify";
import {Head, usePage} from "@inertiajs/react";
import React, {useEffect} from "react";

type Props = {
    title: string
    children: React.ReactNode
}

export default function AppLayout({title, children}: Props) {
    const {flash} = usePage().props;
    useEffect(() => {
        if (flash.success) toast.success(flash.success);
        if (flash.error) toast.error(flash.error);
    }, [flash]);
    return (
        <>
            <Head title={title}></Head>

            {children}

            <ToastContainer/>
        </>
    );
}
