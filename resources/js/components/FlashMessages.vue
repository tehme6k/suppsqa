<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner'

const page = usePage();

watch(() => page.props.flash, (flash) => {
    if (flash.success) {
        toast.success(flash.success);
    }
    if (flash.error) {
        toast.error(flash.error);
    }
}, { deep: true });
</script>

<template>
  <!-- This component has no visual output, it just handles the toast logic -->
</template>