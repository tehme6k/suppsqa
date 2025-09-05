<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { index, store } from "@/routes/products";
import { buttonVariants, Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner'
import {
    Select, SelectContent, SelectItem, SelectLabel, SelectTrigger, SelectValue,
} from '@/components/ui/select'
import { Textarea } from "@/components/ui/textarea"

const form = useForm({
    name: '',
    category_id: '',
    description: ''
})

defineProps({
    categories: {
        type: Array,
        required: true
    },
    flash: {
        type: Object
    }
})



function submitForm() {
    form.post(store(), {
        preserveScroll: true,

        onError: () => {
            toast.error('Form has errors')
        },
        onSuccess: () => {
            toast.success('Product created successfully')
        }

    });
}

const breadcrumbs = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Add Product',
        href: '/products/create',
    },
];
</script>

<template>

    <Head title="Add new Product" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Create a Product</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div class="grid w-full gap-2">
                                <Label for="name">Name</Label>
                                <Input id="name" v-model="form.name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="category_id">Category</Label>
                                <Select id="name" v-model="form.category_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select a category" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="category in categories" :key="category.id"
                                            :value="category.id">
                                            {{ category.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.category_id" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="description">Description</Label>
                                <Textarea id="description" v-model="form.description" />
                                <InputError :message="form.errors.description" />
                            </div>

                            <div class="flex justify-between items-center">
                                <Button variant="default" :disabled="form.processing">Save Product</Button>
                                <Link :href="index()" :class="buttonVariants({ variant: 'ghost' })">Cancel</Link>
                            </div>
                        </form>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>