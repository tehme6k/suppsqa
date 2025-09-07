<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { edit, index, destroy } from "@/routes/vendors";
import { buttonVariants, Button } from '@/components/ui/button';
import FlashMessages from '@/Components/FlashMessages.vue';


defineProps({
    vendor: {
        type: Object,
        required: true
    },
    flash: {
        type: Object
    }
})

const breadcrumbs = [
    {
        title: 'Vendors',
        href: '/vendors',
    },
    {
        title: 'Vendor Details',
        href: '/vendors/show',
    },
];

function deleteItem(id) {
    if (confirm("Are you sure?")) {
        router.delete(destroy(id), {
            preserveScroll: true
        })
    }
}
</script>

<template>

    <Head title="Show Vendor details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Vendor Details</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Name</div>
                            <div>{{ vendor.name }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Website</div>
                            <div>{{ vendor.website }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Email</div>
                            <div>{{ vendor.email }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Phone Number</div>
                            <div>{{ vendor.phone_number }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Contact Name</div>
                            <div>{{ vendor.contact_name }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Created at</div>
                            <div>{{ vendor.formatted_created_at }}</div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <Link :href="index()" :class="buttonVariants({ variant: 'outline' })">Back to Vendors</Link>
                            <div>
                                <Link :href="edit(vendor.id)" :class="buttonVariants({ variant: 'default' })">Edit
                                </Link>
                                <Button @click="deleteItem(vendor.id)" class="ml-2"
                                    variant="destructive">Delete</Button>
                            </div>
                        </div>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>