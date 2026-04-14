<script setup>
import { router } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue';
import Swal from 'sweetalert2';
import { route } from 'ziggy-js';
defineProps({
    products: {
        type: Array,
        required: true
    }
});

const addToCart = (product) => {
    console.log('Adding to cart:', product);
    router.post(route('cart.store', product), {
        onSuccess: (page) => {
            Swal.fire({
                icon: 'success',
                title: page.props.flash.Success,
                text: `${product} has been added to your cart!`,
                timer: 2000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true,
            });
        },
        onError: (errors) => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errors.message || 'Failed to add product to cart.',
            });
        }
    });
}
</script>
<template>
    <UserLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Products List</h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <div v-for="product in products" :key="product.id" class="group relative">
                        <div>
                            <div>
                                <img v-if="product.product_images.length > 0"
                                    :src="`storage/${product.product_images[0].image}`" :alt="product.imageAlt"
                                    class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                                <img v-else
                                    src="https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg"
                                    :alt="product.imageAlt"
                                    class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100 lg:h-80">
                                    <div @click="addToCart(product)"
                                        class="rounded-md bg-white px-4 py-2 text-sm font-medium text-black hover:bg-gray-100 m-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </div>
                                    <div @click="addToCart(product)"
                                        class="rounded-md bg-white px-4 py-2 text-sm font-medium text-black hover:bg-gray-100 m-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a :href="product.href">
                                        {{ product.title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ product.brand.name }}</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
