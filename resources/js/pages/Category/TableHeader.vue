<template>
  <th
    class="p-4 cursor-pointer select-none text-left px-6 py-3" scope="col"
    @click="$emit('sort', field)"
  >
    <div class="flex items-center">
      <span>{{ label }}</span>
      <span v-if="filters.field === field" class="ml-2">
        <span v-if="filters.direction === 'asc'">&#9650;</span>
        <span v-else>&#9660;</span>
      </span>
    </div>
  </th>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps<{
  label: string;
  field: string;
  filters: {
    field?: string;
    direction?: 'asc' | 'desc';
  };
}>();

const emit = defineEmits(['sort']);
</script>
