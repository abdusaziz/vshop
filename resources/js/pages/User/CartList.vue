<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue';

defineProps({
    cartItems: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <UserLayout>

        <Head title="Cart List" />
        <section class="text-gray-600 body-font mx-auto max-w-2xl px-2 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class=" py-6 mx-auto flex sm:flex-nowrap flex-wrap">
                <div class="lg:w-2/3 md:w-1/2 bg-white rounded-lg overflow-hidden sm:mr-10 p-1 ">
                    <div
                        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
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
                                <tr v-for="cartItem in cartItems" :key="cartItem.product_id"
                                    class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                    <td class="p-4">
                                        <img v-if="cartItem.image" :src="`/storage/${cartItem.image}`"
                                            class="w-16 md:w-24 max-w-full max-h-full" alt="Apple Watch">
                                        <img v-else src="https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg"
                                            class="w-16 md:w-24 max-w-full max-h-full" alt="Apple Watch">
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-heading">
                                        {{cartItem}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form class="max-w-xs mx-auto">
                                            <label for="counter-input-1" class="sr-only">Choose quantity:</label>
                                            <div class="relative flex items-center">
                                                <button type="button" id="decrement-button-1"
                                                    data-input-counter-decrement="counter-input-1"
                                                    class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                    <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                                    </svg>
                                                </button>
                                                <input type="text" id="counter-input-1" data-input-counter
                                                    class="shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                    placeholder="" :value="cartItem.quantity" required />
                                                <button type="button" id="increment-button-1"
                                                    data-input-counter-increment="counter-input-1"
                                                    class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                    <svg class="w-3 h-3 text-heading" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 12h14m-7 7V5" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-heading">
                                        $599
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-fg-danger hover:underline">Remove</a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full mt-3 md:mt-0">
                    <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
                    <div>
                        <div class="flex justify-between mt-10 mb-5">
                            <span class="font-semibold text-sm uppercase">Items 3</span>
                            <span class="font-semibold text-sm">$4598</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-sm uppercase">Shipping</span>
                            <span class="font-semibold text-sm">$19</span>
                        </div>
                        <div class="flex justify-between mt-4 mb-4">
                            <span class="font-semibold text-sm uppercase">Total cost</span>
                            <span class="font-semibold text-sm">$4617</span>
                        </div>
                    </div>
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Shipping Address</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">123 abc Road, xyz Town, Pqr Country </p>
                    <p class="leading-relaxed mb-5 text-gray-600"> or add new below</p>
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                        <textarea id="message" name="message"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    <button
                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Check Out</button>
                    <p class="text-xs text-gray-500 mt-3">Continue shopping ...</p>
                </div>
            </div>
        </section>
    </UserLayout>
</template>