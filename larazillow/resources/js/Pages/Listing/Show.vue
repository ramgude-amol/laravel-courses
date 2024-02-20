<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <Box class="md:col-span-7 flex items-center w-full">
            <div class="w-full text-center font-medium text-gray-500">No images</div>
        </Box>
        <div class="md:col-span-5 flex flex-col gap-4">
            <Box>
                <Price :price="listing.price" class="text-2xl font-bold"></Price>
                <ListingSpace :listing="listing" />
                <ListingAddress :listing="listing" />
            </Box>

            <Box>
                <template #header>
                    Monthly Payment
                </template>
                <div>
                    <label class="label"> Interest rate({{ interestRate }}%)</label>
                    <input class="input" type="range" min="0.1" max="10" step="0.1" v-model="interestRate" />

                    <label class="label"> Yeara({{ duration }} years)</label>
                    <input class="input" type="range" min="1" max="35" step="1" v-model="duration" />

                    <div class="text-gray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">Your monthly payment</div>
                        <Price :price="monthlyPayment" class="text-3xl" />
                    </div>
                </div>
            </Box>
        </div>
    </div>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue'
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import MainLayout from '@/Layout/MainLayout.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'
import { ref } from 'vue';


const interestRate = ref(2.5)
const duration = ref(25)

const props = defineProps({ listing: Object })


const { monthlyPayment } = useMonthlyPayment(props.listing.price, interestRate, duration)

</script>


<script>
export default {
    layout: MainLayout
}
</script>