<template>
    <Link href="/">Index</Link> &nbsp; &nbsp;
    <Link href="/show">Show</Link>

    Timer :{{ timer }}
    <slot></slot>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';
var timer = ref(0);
setInterval(() => { timer.value++ }, 1000);
</script>