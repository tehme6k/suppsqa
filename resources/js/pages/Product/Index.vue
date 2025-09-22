<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { show, create, edit, destroy, index } from "@/routes/products"; // Assuming 'categories.show' is a named route
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import FlashMessages from '@/Components/FlashMessages.vue';
import { PaginatedProducts } from '@/types/products';
import { ref, watch } from 'vue';
import TableHeader from '@/Components/TableHeader.vue';

const props = defineProps<{
    products: PaginatedProducts;
    filters: {
        search?: string;
        field?: string;
        direction?: 'asc' | 'desc';
    };
}>();

const search = ref(props.filters.search || '');
// const sort = ref(props.filters.sort || '');

// Search functionality with debouncing
watch(search, (value) => {
    router.get(index(),
        { search: value },
        { preserveState: true, replace: true }
    );
});

// Sorting handler
function handleSort(field: string) {
  let direction: 'asc' | 'desc' = 'asc';
  if (props.filters.field === field && props.filters.direction === 'asc') {
    direction = 'desc';
  }

  router.get(index(),
    { ...props.filters, field, direction },
    { preserveState: true, replace: true }
  );
}

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
                            <TableHeader label="Id" field="id" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Name" field="name" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Category" field="category_id" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Quantity" field="quantity" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Created By" field="user_id" :filters="filters" @sort="handleSort" />
                            <th scope="col" class="px-6 py-3 w-70">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data"
                            class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ product.id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ product.name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ product.category_name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ product.quantity }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ product.user_name }}</td>
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
                <!-- Pagination: -->
                <nav class="flex justify-center mt-5" aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li v-for="link in props.products.links" :key="link.label" :disabled="!link.url">
                            <a :active="link.active" v-if="link.url" :href="link.url" v-html="link.label"
                                :class="['flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white', { 'active-class': link.active }]"></a>
                            <span v-else v-html="link.label"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"></span>
                        </li>
                    </ul>
                </nav>
                <!-- End table to display categories here -->
            </div>
        </div>
    </AppLayout>
</template>

<style>
.active-class {
    background-color: lightblue;
}
</style>