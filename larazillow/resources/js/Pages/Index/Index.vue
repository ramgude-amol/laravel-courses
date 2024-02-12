<template>
    <div>Index vue</div>
    This is Message : {{ message }}
</template>

<script setup>

defineProps({ message: String })
</script>

<script>
import MainLayout from '@/Layout/MainLayout.vue';
export default {
    layout: MainLayout
}
</script>