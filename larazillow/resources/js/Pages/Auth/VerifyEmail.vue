
<template>
    Verified is needed
    <Link :href="route('verification.send')" method="post" as="button"> Resend verification email</Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
