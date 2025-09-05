<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { create, destroy, index, edit, show } from "@/routes/categories"; // Assuming 'categories.show' is a named route
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import FlashMessages from '@/Components/FlashMessages.vue';
import { PaginatedCategories } from '@/types/categories';
import { ref, watch } from 'vue';

const props = defineProps<{
    categories: PaginatedCategories;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

watch(search, (value) => {
    router.get(index(), // Use Laravel's route helper if available
        { search: value },
        { preserveState: true, replace: true }
    );
}); // Optional: debounce for performance

function deleteItem(id) {
    if (confirm("Are you sure?")) {
        router.delete(destroy(id), {
            preserveScroll: true
        })
    }
}

const breadcrumbs = [

    {
        title: 'Categories',
        href: '/categories',
    },
];
</script>

<template>

    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="p-3">
            <!-- <h1 class="text-2xl font-bold mb-4">CRUD App</h1> -->
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="create()"
                        class="mb-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Add category
                    </Link>
                </div>

                <div class="">
                    <input type="text" v-model="search" placeholder="Search categories"
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
                        <tr v-for="category in categories.data"
                            class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ category.id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ category.name }}</td>
                            <td class="px-6 py-2 space-x-1">
                                <Link :href="edit(category.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Edit
                                </Link>
                                <Link :href="show(category.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                Show
                                </Link>
                                <Button @click="deleteItem(category.id)"
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
                        <li v-for="link in props.categories.links" :key="link.label" :disabled="!link.url">
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