<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'border-accent text-start text-base font-medium text-light-text bg-dark focus:outline-none focus:text-light-text focus:bg-dark focus:border-light transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-light-text hover:text-light-text hover:bg-dark hover:border-gray-300 focus:outline-none focus:text-light-text focus:bg-dark focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes" class="block w-full ps-3 pe-4 py-2 border-l-4">
    <slot />
    </Link>
</template>
