<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '../Components/AdminLayout.vue';
import ProductList from './ProductList.vue';

defineProps({
    products: Array
});

</script>
<template>
  <Head title="Products" />
  <AdminLayout>
    <ProductList :products='products'/>
</AdminLayout>
</template>
