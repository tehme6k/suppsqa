<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { index } from "@/routes/inventories";
import { buttonVariants, Button } from '@/components/ui/button';
import FlashMessages from '@/Components/FlashMessages.vue';

function goBack() {
  window.history.back()
}
const props = defineProps({
  inventory: {
    type: Object,
    required: true
  },
  flash: {
    type: Object
  }
})

console.log(props.inventory)

const breadcrumbs = [
  {
    title: 'Inventories',
    href: '/inventories',
  },
  {
    title: 'Inventory Details',
    href: '/inventories/show',
  },
];


</script>

<template>

  <Head title="Show Inventory" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <FlashMessages />
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
      <div class="flex w-full max-w-2xl flex-col">
        <Card class="mt-3">

          <CardHeader>
            <CardTitle>Inventory Details</CardTitle>
          </CardHeader>

          <CardContent class="space-y-3">
            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Name</div>
              <div>{{ inventory.product.name }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Vendor</div>
              <div>{{ inventory.vendor.name }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Lot #</div>
              <div>{{ inventory.lot_number }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Adjustment Type</div>
              <div>{{ inventory.adjustment_type }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Quantity</div>
              <div>{{ inventory.quantity }} {{ inventory.uom }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Quarantine By</div>
              <div>{{ inventory.quarantine_user.name }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Approved By</div>
              <div>{{ inventory.approve_user ? inventory.approve_user.name : 'N/A' }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Facility Location</div>
              <div>{{ inventory.facility_location }}</div>
            </div>

            <div class="flex items-center space-x-4">
              <div class="w-32 font-semibold">Added on</div>
              <div>{{ inventory.formatted_created_at }}</div>
            </div>

            <div class="flex justify-between items-center space-x-4 mt-6">
              <Link :href="index()" :class="buttonVariants({ variant: 'outline' })">Back to Inventory</Link>
              <div>
                <Link  :class="buttonVariants({ variant: 'default' })">Make Adjustment
                </Link>

             
                <!-- <Button class="ml-2" variant="destructive">Delete</Button> -->
              </div>
            </div>
          </CardContent>

        </Card>
      </div>
    </div>
  </AppLayout>
</template>