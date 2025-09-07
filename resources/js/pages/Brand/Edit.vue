<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { index, update } from "@/routes/brands";
import { buttonVariants, Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import FlashMessages from '@/Components/FlashMessages.vue';

const props = defineProps({
    brand: {
        type: Object,
        required: true
    },
    flash: {
        type: Object
    }
})

const form = useForm({
    name: props.brand.name
})
function submitForm() {
    form.put(update(props.brand.id), {
        preserveScroll: true,
    });
}

const breadcrumbs = [
    {
        title: 'Brands',
        href: '/brands',
    },
    {
        title: 'Edit Brand',
        href: '/brands/create',
    },
];
</script>

<template>

    <Head title="Update Brand" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessages />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Brand update</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div class="grid w-full gap-2">
                                <Label for="name">Name</Label>
                                <Input id="name" v-model="form.name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="flex justify-between items-center">
                                <Button variant="default" :disabled="form.processing">Save Brand</Button>
                                <Link :href="index()" :class="buttonVariants({ variant: 'ghost' })">Cancel</Link>
                            </div>
                        </form>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>