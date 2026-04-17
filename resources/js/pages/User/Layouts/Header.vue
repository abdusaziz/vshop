<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const cart = computed(() => {
    const page = usePage();
    return page.props.cart;
})


</script>

<template>

    <Head title="Home" />
    <nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-default">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <Link :href="route('home')" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Flowbite Logo" />
                <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">VShop</span>
            </Link >
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                <!-- corner badge -->
                <button aria-expanded="false" data-dropdown-toggle="cart-dropdown" data-dropdown-placement="bottom"
                    class="relative bg-blue-700 hover:bg-blue-800 duration-300 py-2 px-2 text-blue-100 rounded mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>


                    <span class="absolute bg-red-600 px-2 py-1 text-xs font-bold rounded-full -top-3 -right-3">{{
                        cart.skuCount }}</span>
                </button>
                <!-- Dropdown menu -->
                <div class="left-0 z-50 bg-white text-left hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-350"
                    id="cart-dropdown">
                    <table>
                        <tr v-for="sku in cart.skuItems" key="sku"
                            class="bg-slate-50 border-b border-default hover:bg-slate-100">
                            <th scope="row" class="flex items-center  py-4 text-heading whitespace-nowrap">
                                <img class="w-10 h-10 rounded-full"
                                    :src="sku.image ? `/storage/${sku.image}` : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg'"
                                    alt="Jese image">
                            </th>
                            <th>
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ sku.title }}</div>
                                    <div class="font-normal text-body">{{ sku.price }} X {{ sku.quantity }} = {{
                                        sku.price * sku.quantity }}</div>
                                </div>
                            </th>
                            <th>
                                <div class="pe-3">
                                    <div class="text-base font-semibold text-right" ><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </div>
                                    <div class="font-normal text-body">&nbsp;</div>
                                </div>

                            </th>
                        </tr>
                        <tr class="bg-slate-50 border-b border-default hover:bg-slate-100">
                            <th scope="row" class="flex items-center  py-4 text-heading whitespace-nowrap">

                            </th>
                            <th>
                                <div
                                    class="ps-3 text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 font-medium rounded-base text-sm px-4 py-2.5 text-center leading-5">
                                    <Link href="#">
                                        Check Out
                                    </Link>
                                </div>
                            </th>
                            <th>
                                <div class="pe-3">
                                    
                                </div>

                            </th>
                        </tr>
                    </table>
                </div>


                <div v-if="$page.props.auth.user">
                    <button type="button"
                        class="flex text-sm bg-neutral-primary rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 rounded-full size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="bg-white z-50 hidden border border-default-medium rounded-base shadow-lg w-44"
                        id="user-dropdown">
                        <div class="px-4 py-3 text-sm border-b border-default">
                            <span class="block text-heading font-medium">{{ $page.props.auth.user.name }}</span>
                            <span class="block text-body truncate">{{ $page.props.auth.user.email }}</span>
                        </div>
                        <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
                            <li>
                                <Link :href="route('dashboard')"
                                    class="inline-flex items-center w-full p-2 hover:bg-slate-100 hover:text-slate-900 rounded">
                                    Dashboard</Link>
                            </li>
                            <li>
                                <a href="#"
                                    class="inline-flex items-center w-full p-2 hover:bg-slate-100 hover:text-slate-900 rounded">Settings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="inline-flex items-center w-full p-2 hover:bg-slate-100 hover:text-slate-900 rounded">Earnings</a>
                            </li>
                            <li class="bg-green">
                                <Link
                                    class="inline-flex items-center w-full p-2 hover:bg-slate-100 hover:text-slate-900 rounded"
                                    method="post" :href="route('logout')" as="button">
                                    Log out
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <button data-collapse-toggle="navbar-user" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        aria-controls="navbar-user" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                    </button>
                </div>
                <div v-else class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <Link :href="route('login')" type="button"
                        class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-base text-sm px-4 py-2.5 text-center leading-5">
                        Log In</Link>
                    <Link :href="route('register')"
                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-base text-sm px-4 py-2.5 text-center leading-5 mr-3">
                        Register</Link>


                </div>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-white bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Services</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Pricing</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<style scoped></style>
