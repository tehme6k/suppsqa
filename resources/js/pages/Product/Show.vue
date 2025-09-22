<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { edit, index, destroy } from "@/routes/products";
import { show as categoryShow } from "@/routes/categories";
import { buttonVariants, Button } from '@/components/ui/button';
import FlashMessages from '@/Components/FlashMessages.vue';

defineProps({
    product: {
        type: Object,
        required: true
    },
    flash: {
        type: Object
    }
})

const breadcrumbs = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Products Details',
        href: '/products/show',
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

    <Head title="Product Details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Product Details</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Name</div>
                            <div>{{ product.name }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Category</div>
                            <div><Link :href="categoryShow(product.category.id)">{{ product.category.name }}</Link></div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Description</div>
                            <div>{{ product.description }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Quantity</div>
                            <div>{{ product.quantity }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Created By</div>
                            <div>{{ product.user.name }}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Created At</div>
                            <div>{{ product.formatted_created_at }}</div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <Link :href="index()" :class="buttonVariants({ variant: 'outline' })">Back to Products</Link>
                            <div>
                                <Link :href="edit.url(product.id)" :class="buttonVariants({ variant: 'default' })">Edit
                                </Link>
                                <Button @click="deleteItem(product.id)" class="ml-2"
                                    variant="destructive">Delete</Button>
                            </div>
                        </div>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>