<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '../Components/AdminLayout.vue';

defineProps({
    brands: Array
});

</script>
<template>

    <Head title="Brands" />
    <AdminLayout>


        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                    <tr>
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Qty
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in brands" :key="brand.id" class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                        <td class="p-4">
                            <img :src="`../${brand.image}`" class="w-16 md:w-24 max-w-full max-h-full"
                                :alt="brand.name">
                        </td>
                        <td class="px-6 py-4 font-semibold text-heading">
                            {{ brand.name }}
                        </td>
                        <td class="px-6 py-4">
                            <form class="max-w-xs mx-auto">
                                <label for="counter-input-1" class="sr-only">Choose quantity:</label>
                                <div class="relative flex items-center">
                                    <button type="button" id="decrement-button-1"
                                        data-input-counter-decrement="counter-input-1"
                                        class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                        <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 12h14" />
                                        </svg>
                                    </button>
                                    <input type="text" id="counter-input-1" data-input-counter
                                        class="shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                        placeholder="" value="12" required />
                                    <button type="button" id="increment-button-1"
                                        data-input-counter-increment="counter-input-1"
                                        class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                        <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 12h14m-7 7V5" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-green-700 hover:underline">Edit</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-red-700 hover:underline">Remove</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </AdminLayout>

</template>