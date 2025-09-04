<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { show, create, edit, destroy } from "@/routes/products"; // Assuming 'categories.show' is a named route
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import FlashMessages from '@/Components/FlashMessages.vue';

const props = defineProps({
    products: {
        type: Array,
        required: true
    },
    flash: {
        type: Object
    }
})

function deleteItem(id) {
    if (confirm("Are you sure?")) {
        router.delete(destroy(id), {
            preserveScroll: true
        })
    }
}

const breadcrumbs = [

    {
        title: 'Products',
        href: '/products',
    },
];
</script>

<template>

    <Head title="Products" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="p-3">
            <!-- <h1 class="text-2xl font-bold mb-4">CRUD App</h1> -->
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="create()"
                        class="mb-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Add product
                    </Link>
                </div>

                <div class="">
                    <input type="text" v-model="search" placeholder="Search products"
                        class="border border-gray-300 p-2 rounded-md mr-5 w-[400px]" />
                </div>

            </div>
            <div class="overflow-x-auto mt-2">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3 w-70">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in props.products"
                            class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ product.id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ product.name }}</td>
                            <td class="px-6 py-2 space-x-1">
                                <Link :href="edit.url(product.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Edit
                                </Link>
                                <Link :href="show.url(product.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                Show
                                </Link>
                                <Button @click="deleteItem(product.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    Delete
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>