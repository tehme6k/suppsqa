<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { index, store } from "@/routes/vendors";
import { buttonVariants, Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner'
import { Textarea } from "@/components/ui/textarea"

const form = useForm({
    name: '',
    website: '',
    email: '',
    phone_number: '',
    contact_name: '',
    notes: ''
})

function submitForm() {
    form.post(store(), {
        preserveScroll: true,

        onError: () => {
            toast.error('Form has errors')
        },
        onSuccess: () => {
            toast.success('Vendor created successfully')
        }

    });
}

const breadcrumbs = [
    {
        title: 'Vendors',
        href: '/vendors',
    },
    {
        title: 'Add Vendor',
        href: '/vendors/create',
    },
];
</script>

<template>

    <Head title="Add new Vendor" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Vendor Create</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div class="grid w-full gap-2">
                                <Label for="name">Name</Label>
                                <Input id="name" v-model="form.name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="grid grid-cols-2 gap-6">

                                <div class="grid w-full gap-2">
                                    <Label for="website">Website</Label>
                                    <Input id="website" v-model="form.website" />
                                    <InputError :message="form.errors.website" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="email">Email</Label>
                                    <Input type="email" id="email" v-model="form.email" />
                                    <InputError :message="form.errors.email" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="phone_number">Phone number</Label>
                                    <Input id="phone_number" v-model="form.phone_number" />
                                    <InputError :message="form.errors.phone_number" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="contact_name">Contact Name</Label>
                                    <Input id="contact_name" v-model="form.contact_name" />
                                    <InputError :message="form.errors.contact_name" />
                                </div>


                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="notes">Notes</Label>
                                <Textarea id="notes" v-model="form.notes" />
                                <InputError :message="form.errors.notes" />
                            </div>

                            <div class="flex justify-between items-center">
                                <Button variant="default" :disabled="form.processing">Save Vendor</Button>
                                <Link :href="index()" :class="buttonVariants({ variant: 'ghost' })">Cancel</Link>
                            </div>
                        </form>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>