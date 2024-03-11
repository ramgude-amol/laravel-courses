<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <Box v-if="listing.images.length" class="md:col-span-7 flex items-center w-full">
            <div class="grid grid-cols-2 gap-1">
                <img v-for="image in listing.images" :key="image.id" :src="image.src">
            </div>
        </Box>
        <EmptyState v-else class="md:col-span-7 flex items-center">No images</EmptyState>

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

                    <div class="flex justify-between">
                        <div>Total paid</div>
                        <div>
                            <Price :price="totalPaid" class="font-medium" />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Principle</div>
                        <div>
                            <Price :price="listing.price" class="font-medium" />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Total Interest paid</div>
                        <div>
                            <Price :price="totalInterestPaid" class="font-medium" />
                        </div>
                    </div>
                </div>
            </Box>

            <Makeoffer v-if="!offerMade" :listing-id="listing.id" :price="listing.price" @offeru="offer = $event" />

            <OfferMade v-if="offerMade" :offer="offerMade"></OfferMade>
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
import Makeoffer from '@/Pages/Listing/Show/Components/Makeoffer.vue';
import { ref } from 'vue';
import OfferMade from '@/Pages/Listing/Show/Components/OfferMade.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';

const interestRate = ref(2.5)
const duration = ref(25)
const props = defineProps({
    listing: Object,
    offerMade: Object
})

const offer = ref(props.listing.price).value
const { monthlyPayment, totalInterestPaid, totalPaid } = useMonthlyPayment(
    offer, interestRate, duration
)
</script>


<script>
export default {
    layout: MainLayout
}
</script>