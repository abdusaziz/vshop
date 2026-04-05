<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Header from './Header.vue';
import Hero from './Hero.vue';
import Footer from './Footer.vue';

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>
<template>
    <!-- Header Start -->
    <Header />
    <!-- Header End -->

    <!-- Main Content Start -->

    <!-- Hero Section Start -->
    <Hero />
    <!-- Hero Section End -->

    <slot />

    <!-- Main Content End -->

    <!-- Footer Start -->
    <Footer />
    <!-- Footer End -->

</template>
