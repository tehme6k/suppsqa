<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle  } from '@/components/ui/card';
import { edit, index } from "@/routes/categories";
import { buttonVariants, Button } from '@/components/ui/button';
import {deleteItem} from '@/composables/useItem'

const indexUrl = index();

defineProps({
    category: {
        type: Object,
        required: true
    }
})

const breadcrumbs = [
    {
        title: 'Categories',
        href: '/categories',
    },
        {
        title: 'Category Details',
        href: '/categories/show',
    },
];
</script>

<template>

    <Head title="Show Category" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Category Details</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Name</div>
                            <div>{{ category.name }}</div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <Link :href="indexUrl" :class="buttonVariants({variant: 'outline'})">Back</Link>  
                            <div>
                                <Link :href="edit.url(category.id)" :class="buttonVariants({variant: 'default'})">Edit</Link> 
                                <Button @click="deleteItem(category.id)" class="ml-2" variant="destructive">Delete</Button>
                            </div>
                        </div>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>
