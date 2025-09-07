<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { edit, index, destroy } from "@/routes/brands";
import { buttonVariants, Button } from '@/components/ui/button';
import FlashMessages from '@/Components/FlashMessages.vue';

defineProps({
    brand: {
        type: Object,
        required: true
    },
    flash: {
        type: Object
    }
})

const breadcrumbs = [
    {
        title: 'Brands',
        href: '/brands',
    },
    {
        title: 'Brand Details',
        href: '/brands/show',
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

    <Head title="Show Brand" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Brand Details</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Name</div>
                            <div>{{ brand.name }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Created at</div>
                            <div>{{ brand.formatted_created_at }}</div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <Link :href="index()" :class="buttonVariants({ variant: 'outline' })">Back to Brands</Link>
                            <div>
                                <Link :href="edit.url(brand.id)" :class="buttonVariants({ variant: 'default' })">Edit
                                </Link>
                                <Button @click="deleteItem(brand.id)" class="ml-2" variant="destructive">Delete</Button>
                            </div>
                        </div>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>