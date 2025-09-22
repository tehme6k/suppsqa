<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Inventory by Lot Number</h1>
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr>
            <th class="py-2 px-4 border-b">Product</th>
          <th class="py-2 px-4 border-b">Lot Number</th>
          <th class="py-2 px-4 border-b">Total Quantity</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in inventoryByLot" :key="item.lot_number">
            <td class="py-2 px-4 border-b">{{ item.product.name }}</td>
          <td class="py-2 px-4 border-b">{{ item.lot_number }}</td>
          <td class="py-2 px-4 border-b">{{ item.total_quantity }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';


const props = defineProps({
    inventoryByLot: {
        type: Array,
        required: true
    },
    flash: {
        type: Object
    }
})

console.log(props)
</script>

