<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { show, create, edit } from "@/routes/categories"; // Assuming 'categories.show' is a named route
import { Head, Link } from '@inertiajs/vue3';
// import {deleteItem} from '@/composables/useItem'
import { dashboard } from '@/routes';
import { buttonVariants, Button } from '@/components/ui/button';
import { toast } from 'vue-sonner'
import { router } from '@inertiajs/vue3';
import { destroy } from "@/routes/categories";
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

// import Categories from '@/routes/categories';

// const createUrl = create();

const props = defineProps({
    categories: {
        type: Array,
        required: true
    },
    flash: {
        type: Object
    }
})

    const page = usePage();

    watch(() => page.props.flash, (flash) => {
        if (props.flash.success) {
            toast.success(props.flash.success);
        } else if (props.flash.error) {
            toast.error(props.flash.error);
        }
        // Add conditions for other flash types (info, warning) if used
    }, { deep: true });

    function deleteItem (id) {
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
        <div v-if="props.flash.error">Error</div>
        <div class="p-3">
            <!-- <h1 class="text-2xl font-bold mb-4">CRUD App</h1> -->
            <Link
            :href="create()"
                class="mb-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Add category
        </Link>
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
                        <tr v-for="category in props.categories"
                            class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ category.id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ category.name }}</td>
                            <td class="px-6 py-2 space-x-1">
                                <Link :href="edit.url(category.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Edit
                            </Link>
                                <Link :href="show.url(category.id)"
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
            </div>
        </div>
    </AppLayout>
</template>
