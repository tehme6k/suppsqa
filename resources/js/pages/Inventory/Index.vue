<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { show, create, destroy, index } from "@/routes/inventories"; // Assuming 'categories.show' is a named route
import { adjust } from "@/routes/inventory"; // Assuming 'categories.show' is a named route
import { approve } from "@/routes/inventory"; // Assuming 'categories.show' is a named route
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import FlashMessages from '@/Components/FlashMessages.vue';
import { PaginatedInventories } from '@/types/inventories';
import { ref, watch } from 'vue';
import TableHeader from '@/Components/TableHeader.vue';

const props = defineProps<{
    inventories: PaginatedInventories;
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

function approveItem(id) {
if (confirm("Do you want to move this out of quarantine? id: " + id)) {
        console.log("approved")
        router.post(approve(), { id }, {
            preserveScroll: true
        })
    }   
}

const breadcrumbs = [

    {
        title: 'Inventories',
        href: '/inventories',
    },
];
</script>

<template>

    <Head title="Inventory History" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="p-3">
            <!-- <h1 class="text-2xl font-bold mb-4">CRUD App</h1> -->
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="create()"
                        class="mb-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Receieve a shipment
                    </Link>
                </div>

                <div class="">
                    <input type="text" v-model="search" placeholder="Search by product or lot#  "
                        class="border border-gray-300 p-2 rounded-md mr-5 w-[400px]" />
                </div>
            </div>
            <div class="overflow-x-auto mt-2">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                        <tr>
                            <TableHeader label="Id" field="id" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Product Name" field="product_id" :filters="filters"
                                @sort="handleSort" />
                            <TableHeader label="Lot Number" field="lot_number" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Adjustment Type" field="adjustment_type" :filters="filters"
                                @sort="handleSort" />
                            <TableHeader label="Quantity" field="quantity" :filters="filters" @sort="handleSort" />
                            <TableHeader label="UOM" field="uom" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Vendor" field="vendor_id" :filters="filters" @sort="handleSort" />
                            <TableHeader label="Facility Location" field="facility_location" :filters="filters"
                                @sort="handleSort" />
                            <TableHeader label="Expiration" field="expiration_date" :filters="filters"
                                @sort="handleSort" />
                            <TableHeader label="Created" field="created_at" :filters="filters" @sort="handleSort" />
                            <th scope="col" class="px-6 py-3 w-70">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inventory in inventories.data"
                            class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ inventory.id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.product_name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.lot_number }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.adjustment_type }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.quantity }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.uom }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.vendor_name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ inventory.facility_location }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ new
                                Date(inventory.expiration_date).toLocaleDateString() }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ new Date(inventory.created_at).toLocaleDateString()
                                }}</td>
                            <td class="px-6 py-2 space-x-1">



                                <Link :href="show.url(inventory.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                Show
                                </Link>

                                <!-- <Link v-if="inventory.facility_location === 'quarantine'" :href="edit.url(inventory.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Approve
                                </Link> -->

                                <Button @click="approveItem(inventory.id)" v-if="inventory.facility_location === 'quarantine'"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Approve
                                </Button>

                                <Link v-else :href="adjust.url(inventory.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Adjustment
                                </Link>

                                <!-- <Button @click="deleteItem(inventory.id)"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    Delete
                                </Button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination: -->
                <nav class="flex justify-center mt-5" aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li v-for="link in props.inventories.links" :key="link.label" :disabled="!link.url">
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