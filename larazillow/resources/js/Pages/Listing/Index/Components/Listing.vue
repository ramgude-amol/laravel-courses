<template>
    <Box>
        <div>
            <Link :href="route('listing.show', { listing: eachListing.id })">
            <div class="flex items-center gap-2">
                <Price :price="eachListing.price" class="text-2xl font-bold" /> &nbsp;
                (<div class="text-xs text-gray-400">
                    <Price :price="monthlyPayment" />PM
                </div>)
            </div>
            <ListingSpace :listing="eachListing" />
            <ListingAddress :listing="eachListing" />
            </Link>
        </div>
    </Box>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '@/Components/ListingAddress.vue'
import ListingSpace from '@/Components/ListingSpace.vue'
import Price from '@/Components/Price.vue'
import Box from '@/Components/UI/Box.vue'
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'

const props = defineProps({ eachListing: Object })
const { monthlyPayment } = useMonthlyPayment(props.eachListing.price, 2.5, 25);
</script>
