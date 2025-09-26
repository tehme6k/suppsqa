<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { index, store } from "@/routes/inventories";
import { buttonVariants, Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner'
import {
    Select, SelectContent, SelectItem, SelectLabel, SelectTrigger, SelectValue,
} from '@/components/ui/select'
import { Textarea } from "@/components/ui/textarea"
import { User } from '@/types/index';





const props = defineProps({
    vendors: {
        type: Array,
        required: true
    },
    inventory: {
        type: Object,
        required: true
    },
    products: {
        type: Array,
        required: true
    },
    user: {
        type: Object,
        required: true
    },
    flash: {
        type: Object
    }
})

const form = useForm({
    product_id: props.inventory.product.id,
    vendor_id: props.inventory.vendor.id,
    lot_number: props.inventory.lot_number,
    facility_location: 'quarantine',
    adjustment_type: 'receive',
    quantity: '',
    uom: '',
    expiration_date: props.inventory.expiration_date,
    description: '',
    quarantine_user: props.user.id,
})

console.log('props');



function submitForm() {
    form.post(store(), {
        preserveScroll: true,

        onError: () => {
            toast.error('Form has errors')
        },
        onSuccess: () => {
            toast.success('Inventory created successfully')
        }

    });
}

const breadcrumbs = [
    {
        title: 'Inventory',
        href: '/products',
    },
    {
        title: 'Receive Stock',
        href: '/products/create',
    },
];
</script>

<template>

    <Head title="Receive Inventory" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">

                    <CardHeader>
                        <CardTitle>Add to inventory</CardTitle>
                    </CardHeader>

                    <CardContent class="space-y-3">
                        <form @submit.prevent="submitForm" class="space-y-6">

                            <div class="grid grid-cols-2 gap-6">
                               
                                <div class="grid w-full gap-2">
                                    <Label for="product_id">Product</Label>
                                    <Select disabled id="product_id" v-model="form.product_id">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select a product" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem v-for="product in props.products" :key="product.id"
                                                :value="product.id">
                                                {{ product.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <InputError :message="form.errors.product_id" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="vendor_id">Vendor</Label>
                                    <Select disabled id="name" v-model="form.vendor_id">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select a vendor" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">
                                                {{ vendor.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <InputError :message="form.errors.vendor_id" />
                                </div>


                                <div class="grid w-full gap-2">
                                    <Label for="lot_number">Lot Number</Label>
                                    <Input disabled id="name" v-model="form.lot_number" />
                                    <InputError :message="form.errors.lot_number" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="expiration_date">Expiration Date</Label>
                                    <Input disabled id="name" type="date" v-model="form.expiration_date" />
                                    <InputError :message="form.errors.expiration_date" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="quantity">Quantity</Label>
                                    <Input id="name" type="text" v-model="form.quantity" />
                                    <InputError :message="form.errors.quantity" />
                                </div>

                                <div class="grid w-full gap-2">
                                    <Label for="uom">UOM</Label>
                                    <Select id="uom" v-model="form.uom">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select a Unit of measure" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="kg">Kilograms</SelectItem>
                                            <!-- <SelectItem value="lb">Pounds</SelectItem> -->
                                            <SelectItem value="ea">Each</SelectItem>
                                            <SelectItem value="g">Grams</SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <InputError :message="form.errors.uom" />
                                </div>


                            </div>
                            <!-- <div class="grid w-full gap-2">
                                <Label for="description">Description</Label>
                                <Textarea id="description" v-model="form.description" />
                                <InputError :message="form.errors.description" />
                            </div> -->

                            <div class="flex justify-between items-center">
                                <Button variant="default" :disabled="form.processing">Save Inventory</Button>
                                <Link :href="index()" :class="buttonVariants({ variant: 'ghost' })">Cancel</Link>
                            </div>
                        </form>
                    </CardContent>

                </Card>
            </div>
        </div>
    </AppLayout>
</template>