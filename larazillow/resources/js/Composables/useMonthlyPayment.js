import { computed, isRef } from "vue"

export const useMonthlyPayment = (principle, interestRate, duration) => {
    const monthlyPayment = computed(() => {
        const monthlyInterest = (isRef(interestRate) ? interestRate.value : interestRate) / 100 / 12
        const numberOfPaymentMonths = (isRef(duration) ? duration.value : duration) * 12

        return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
    })

    const totalPaid = computed(
        () => { return (isRef(duration) ? duration.value : duration)  * 12 * monthlyPayment.value }
    )

    const totalInterestPaid = computed(
        () => { return totalPaid.value - principle }
    )


    return { monthlyPayment, totalInterestPaid, totalPaid }
}