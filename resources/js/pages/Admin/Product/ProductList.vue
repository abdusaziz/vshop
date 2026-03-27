<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';
import { Delete, Download, Plus, ZoomIn } from '@element-plus/icons-vue'

const { products } = defineProps({
    products: Array
});

const id = ref('');
const title = ref('');
const price = ref('');
const quantity = ref('');
const description = ref('');
const product_images = ref([]);
const publised = ref('');
const category_id = ref('');
const brand_id = ref('');
const inStock = ref('');
const selectedCategory = ref(null) // This will store the whole object
const selectedBrand = ref(null) // This will store the whole object


const productImages = ref([
    {
        id: 7,
        isOld: 1,
        name: 'food.jpeg',
        url: '/product_images/1774610764-V2QmN2SQB7.jpg',
    },
]);
const OldImages = ref([]);


const resetForm = () => {
    id.value = '';
    title.value = '';
    price.value = '';
    quantity.value = '';
    description.value = '';
    product_images.value = [];
    publised.value = '';
    category_id.value = '';
    brand_id.value = '';
    inStock.value = '';
    productImages.value = [];
    OldImages.value = [];
    selectedCategory.value = null;
    selectedBrand.value = null;

}

const addProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('published', publised.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);
    formData.append('inStock', inStock.value);
    console.log(productImages.value);
    for (const image of productImages.value) {
        if (image.isOld) {
            continue;
        }
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('/admin/products/store', formData, {
            onSuccess: page => {
                Swal.fire({
                    title: 'Product added!',
                    text: page.props?.flash?.success || 'Product added successfully',
                    icon: 'success',
                    timer: 1600,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true,
                });
                dialogVisible.value = false;
            }
        });
    } catch (error) {
        console.log(error);
    }
};

const updateProduct = async () => {
    const formData = new FormData();
    formData.append('id', id.value);
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('published', publised.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);
    formData.append('inStock', inStock.value);
    formData.append('_method', "PATCH");

    for (const image of productImages.value) {
        if (image.isOld) {
            continue;
        }
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('/admin/products/update/'+id.value, formData, {
            onSuccess: page => {
                Swal.fire({
                    title: 'Product updated!',
                    text: page.props?.flash?.success || 'Product updated successfully',
                    icon: 'success',
                    timer: 1600,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true,
                });
                dialogVisible.value = false;
            }
        });
    } catch (error) {
        console.log(error);
    }
};


const dialogVisible = ref(false);
const isAddProduct = ref(false);
const editMode = ref(false);

const openAddModal = () => {
    dialogVisible.value = true;
    isAddProduct.value = true;
    editMode.value = false;
    resetForm();
}
const openEditModal = (product) => {
    console.log(product);
    title.value = product.title;

    id.value = product.id;
    title.value = product.title;
    price.value = product.price;
    quantity.value = product.quantity;
    description.value = product.description;
    productImages.value= product.product_images.map(img => ({
        id: img.id,
        isOld: 1,
        name: img.image,
        url: "/"+img.image,
    }));
    publised.value = product.publised;
    category_id.value = product.category_id;
    selectedCategory.value = product.category ? product.category.name : null;
    brand_id.value = product.brand_id;
    selectedBrand.value = product.brand ? product.brand.name : null;
    inStock.value = product.inStock;

console.log(product_images.value);



    dialogVisible.value = true;
    isAddProduct.value = false;
    editMode.value = true;
}

const deleteProduct = (productId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/admin/products/delete/${productId}`, {
                onSuccess: page => {
                    Swal.fire(
                        'Deleted!',
                        page.props?.flash?.success || 'Product deleted successfully',
                        'success'
                    );
                }
            });
        }
    });
}

const handleClose = () => {
    dialogVisible.value = false;
};


// Category select option with search Start

// 1. Access the prop (Inertia handles the Proxy reactivity automatically)
const categories = usePage().props.categories;

const isOpenCategory = ref(false)
const searchCategory = ref('')


// 2. Filter by the "name" property
const filteredCategoryOptions = computed(() => {
    if (!searchCategory.value) return categories;

    return categories.filter(cat =>
        cat.name.toLowerCase().includes(searchCategory.value.toLowerCase())
    )
})

const selectCategory = (cat) => {
    selectedCategory.value = cat.name // Store the name for display
    category_id.value = cat.id // Store the name for display
    isOpenCategory.value = false
    searchCategory.value = ''
    // If using with an Inertia form: form.category_id = cat.id
}

// Category select option with search End



// brand select option with search Start

// 1. Access the prop (Inertia handles the Proxy reactivity automatically)
const brands = usePage().props.brands;

const isOpenBrand = ref(false)
const searchBrand = ref('')

// 2. Filter by the "name" property
const filteredBrandOptions = computed(() => {
    if (!searchBrand.value) return brands;

    return brands.filter(brn =>
        brn.name.toLowerCase().includes(searchBrand.value.toLowerCase())
    )
})

const selectBrand = (brn) => {
    selectedBrand.value = brn.name // Store the name for display
    brand_id.value = brn.id // Store the name for display
    isOpenBrand.value = false
    searchBrand.value = ''
    // If using with an Inertia form: form.brand_id = cat.id
}

// brand select option with search End


// Multiple Image Upload Start

const dialogImageUrl = ref('')
const dialogVisibles = ref(false)
const disabled = ref(false)

const handleRemove = (file) => {
    console.log(file, 'Hit API to remove this image')

    // If the image is old, call the API to delete it from the server
    if (file.isOld) {
        router.delete(`/admin/products/image/delete/${file.id}`, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    title: 'Product image deleted!',
                    text: page.props?.flash?.success || 'Product image deleted successfully',
                    icon: 'success',
                    timer: 1600,
                    showConfirmButton: false,
                    position: 'top-end',
            });
            }
        });
    }
    

    

    const index = productImages.value.indexOf(file)
    console.log(file.id);
    if (index > -1) {
        productImages.value.splice(index, 1)
    }



}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogVisibles.value = true
}

const handleDownload = (file) => {
    console.log(file)
}

// Multiple Image Upload End
</script>
<template>
    <el-dialog v-model="dialogVisible" :title="editMode ? 'Edit Product' : 'Add Product'" width="500"
        :before-close="handleClose">


        <!-- Start form -->

        <form @submit.prevent="submit" class="max-w-md mx-auto">
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="title" type="text" name="floating_title" id="floating_title"
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                    placeholder=" " required />
                <label for="floating_title"
                    class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Title</label>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="price" type="text" name="floating_price" id="floating_price"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required />
                    <label for="floating_price"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Price</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="quantity" type="text" name="floating_quantity" id="floating_company"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                        placeholder=" " required />
                    <label for="floating_quantity"
                        class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Quantity</label>
                </div>
            </div>


            <!-- Category Select Option Start-->
            <div id="category-select" class="mb-5">
                <label for="category_id" class="block mb-2.5 text-sm font-medium text-heading">Category</label>
                <div class="relative w-100">
                    <!-- Toggle Button -->
                    <button @click="isOpenCategory = !isOpenCategory"
                        class="w-full flex items-center justify-between px-4 py-2 bg-white border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="truncate">{{ selectedCategory || 'Select an option' }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div v-if="isOpenCategory" class="absolute z-10 w-full mt-2 bg-white border rounded-lg shadow-lg">
                        <!-- Search Input -->
                        <div class="p-2 border-b">
                            <input v-model="searchCategory" type="text" placeholder="Search..." name="category_id"
                                id="category_id"
                                class="w-full px-3 py-1.5 text-sm border rounded focus:outline-none focus:border-blue-500"
                                ref="searchInput" />
                        </div>

                        <!-- Options List -->
                        <ul class="max-h-60 overflow-y-auto py-1">
                            <li v-for="option in filteredCategoryOptions" :key="option.id"
                                @click="selectCategory(option)"
                                class="px-4 py-2 text-sm hover:bg-blue-50 cursor-pointer transition-colors">
                                {{ option.name }}
                            </li>
                            <li v-if="filteredCategoryOptions.length === 0"
                                class="px-4 py-2 text-sm text-gray-500 italic">
                                No results found
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Category Select Option End-->


            <!-- Brand Select Option Start-->
            <div id="brnad-select" class="mb-5">
                <label for="brand_id" class="block mb-2.5 text-sm font-medium text-heading">Brand</label>
                <div class="relative w-100">
                    <!-- Toggle Button -->
                    <button @click="isOpenBrand = !isOpenBrand"
                        class="w-full flex items-center justify-between px-4 py-2 bg-white border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="truncate">{{ selectedBrand || 'Select an Brand' }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div v-if="isOpenBrand" class="absolute z-10 w-full mt-2 bg-white border rounded-lg shadow-lg">
                        <!-- Search Input -->
                        <div class="p-2 border-b">
                            <input v-model="searchBrand" type="text" placeholder="Search..." name="brand_id"
                                id="brand_id"
                                class="w-full px-3 py-1.5 text-sm border rounded focus:outline-none focus:border-blue-500"
                                ref="searchInput" />
                        </div>

                        <!-- Options List -->
                        <ul class="max-h-60 overflow-y-auto py-1">
                            <li v-for="option in filteredBrandOptions" :key="option.id" @click="selectBrand(option)"
                                class="px-4 py-2 text-sm hover:bg-blue-50 cursor-pointer transition-colors">
                                {{ option.name }}
                            </li>
                            <li v-if="filteredBrandOptions.length === 0" class="px-4 py-2 text-sm text-gray-500 italic">
                                No results found
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Category Select Option End-->

            <div class="relative z-0 w-full mb-5 group">
                <label for="description" class="block mb-2.5 text-sm font-medium text-heading">Description</label>
                <textarea v-model="description" id="description" rows="4"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                    placeholder="Write product description here..."></textarea>
            </div>

            <!-- Multiple Image Upload Start -->

            <div class="relative z-0 w-full mb-5 group">
                <el-upload v-model:file-list="productImages" list-type="picture-card" :auto-upload="false">
                    <el-icon>
                        <Plus />
                    </el-icon>

                    <template #file="{ file }">
                        <div>
                            <img class="el-upload-list__item-thumbnail" :src="file.url" alt="" />
                            <span class="el-upload-list__item-actions">
                                <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <el-icon><zoom-in /></el-icon>
                                </span>
                                <!-- <span v-if="!disabled" class="el-upload-list__item-delete"
                                    @click="handleDownload(file)">
                                    <el-icon>
                                        <Download />
                                    </el-icon>
                                </span> -->
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemove(file)">
                                    <el-icon>
                                        <Delete />
                                    </el-icon>
                                </span>
                            </span>
                        </div>
                    </template>


                </el-upload>

                <el-dialog v-model="dialogVisibles">
                    <img w-full :src="dialogImageUrl" alt="Preview Image" />
                </el-dialog>
            </div>

            <!-- Multiple Image Upload End -->




        </form>

        <!-- End form -->


        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button v-if="isAddProduct" type="primary" @click="addProduct">
                    Create Product
                </el-button>
                <el-button v-if="editMode" type="primary" @click="updateProduct">
                    Update Product
                </el-button>
            </div>
        </template>
    </el-dialog>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-screen-xl">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" @click="openAddModal"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add product
                        </button>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                Actions
                            </button>
                            <div id="actionsDropdown"
                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#"
                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                            Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                        all</a>
                                </div>
                            </div>
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center">
                                        <input id="apple" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple
                                            (56)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="fitbit" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="fitbit"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft
                                            (16)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="razor" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="razor"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor
                                            (49)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="nikon" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="nikon"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon
                                            (12)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="benq" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="benq"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ
                                            (74)</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Product name</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Brand</th>
                                <th scope="col" class="px-4 py-3">Quantity</th>
                                <th scope="col" class="px-4 py-3">Price</th>
                                <th scope="col" class="px-4 py-3">Stock</th>
                                <th scope="col" class="px-4 py-3">Publish</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                        product.title }}</th>
                                <td class="px-4 py-3">{{ product.category.name }}</td>
                                <td class="px-4 py-3">{{ product.brand.name }}</td>
                                <td class="px-4 py-3">{{ product.quantity }}</td>
                                <td class="px-4 py-3">${{ product.price }}</td>
                                <td class="px-4 py-3">
                                    <span v-if="product.inStock == 1"
                                        class="bg-green-100 text-fg-success-strong text-sm font-medium px-2 py-1 rounded">inStock</span>
                                    <span v-else
                                        class="bg-red-100 text-fg-danger-strong text-sm font-medium px-2 py-1 rounded">OutOfStock</span>
                                </td>
                                <td class="px-4 py-3">
                                    <button v-if="product.published == 1"
                                        class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300">Published</button>
                                    <button v-else
                                        class="rounded-lg px-4 py-2 bg-red-600 text-red-100 hover:bg-red-700 duration-300">UnPublished</button>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="`${product.id}-dropdown-button`"
                                        :data-dropdown-toggle="`${product.id}-dropdown`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div :id="`${product.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${product.id}-dropdown-button`">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                            </li>
                                            <li>
                                                <a href="#" @click="openEditModal(product)"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteProduct(product.id)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</template>


<style scoped>
.avatar-uploader .avatar {
    width: 178px;
    height: 178px;
    display: block;
}

.avatar-uploader .el-upload {
    border: 1px dashed var(--el-border-color);
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: var(--el-transition-duration-fast);
}

.avatar-uploader .el-upload:hover {
    border-color: var(--el-color-primary);
}

.el-icon.avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    text-align: center;
}
</style>