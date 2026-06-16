import {Head} from "@inertiajs/react";
import PricingTable from "@/Components/PricingTable";

export default function Plans() {
    return (
        <>
            <Head title="Planes"/>

            <main className="mt-5">
                <PricingTable/>
            </main>
        </>
    );
}
