import {usePage} from "@inertiajs/react";
import SubscriptionStatus from "@/Components/Subscriptions/SubscriptionStatus";
import {Subscription} from "@/Types/Subscription";
import SubscriptionUpgrade from "@/Components/Subscriptions/SubscriptionUpgrade";
import SubscriptionDowngrade from "@/Components/Subscriptions/SubscriptionDowngrade";
import SubscriptionCancellation from "@/Components/Subscriptions/SubscriptionCancellation";
import {toast} from "react-toastify";
import {useEffect} from "react";
import SubscriptionResume from "@/Components/Subscriptions/SubscriptionResume";
import AppLayout from "@/Layouts/AppLayout";

type Props = {
    subscription: Subscription;
    user_name: string;
};

const statusColors = {
    green: "bg-green-500/10 text-green-400 border-green-500/20",
    yellow: "bg-yellow-500/10 text-yellow-400 border-yellow-500/20",
    orange: "bg-orange-500/10 text-orange-400 border-orange-500/20",
    red: "bg-red-500/10 text-red-400 border-red-500/20",
    gray: "bg-white/[0.04] text-white/50 border-white/[0.08]",
};

export default function Manage({subscription, user_name}: Props) {
    const isYearly = subscription.plan === "yearly";

    return (
        <AppLayout title="Administra Tu Subscripcion">

            <main className="max-w-2xl mx-auto py-12 px-4">
                {/* Header */}
                <div className="mb-8">
                    <p className="text-white/25 text-xs font-medium tracking-widest uppercase mb-3">
                        {user_name}
                    </p>
                    <h1 className="text-2xl font-bold text-white tracking-tight mb-1">
                        Tu Suscripción
                    </h1>
                    <p className="text-white/40 text-sm">
                        Cambia tu plan, cancela o reactiva cuando quieras.
                    </p>
                </div>

                {/* Status card */}
                <SubscriptionStatus
                    isYearly={isYearly}
                    price={subscription.price}
                    status_label={subscription.status_label}
                    color={statusColors[subscription.status_label.color]}
                />

                {/* Actions */}
                {subscription.on_grace_period ? (
                    <SubscriptionResume ends_at={subscription.ends_at}/>
                ) : (
                    <div className="flex flex-col gap-4">
                        {!isYearly && <SubscriptionUpgrade/>}
                        {isYearly && (
                            <SubscriptionDowngrade
                                next_billing_date={
                                    subscription.next_billing_date
                                }
                                ends_at={subscription.ends_at}
                            />
                        )}
                        <SubscriptionCancellation
                            next_billing_date={subscription.next_billing_date}
                        />
                    </div>
                )}
            </main>
        </AppLayout>
    );
}
