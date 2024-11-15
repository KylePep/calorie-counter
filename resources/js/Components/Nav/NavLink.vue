<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? ' border-accent-light text-lg font-bold leading-5 text-accent-light focus:outline-none focus:border-light transition duration-150 ease-in-out'
        : ' border-transparent text-lg font-medium leading-5 text-light-text hover:text-light-text hover:border-light focus:outline-none focus:text-light-text focus:border-light transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes" class="inline-flex items-center px-1 py-1 border-b-2 uppercase">
    <slot />
    </Link>
</template>
