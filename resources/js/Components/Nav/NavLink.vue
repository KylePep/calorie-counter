<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? ' border-accent text-sm font-medium leading-5 text-accent focus:outline-none focus:border-light transition duration-150 ease-in-out'
        : ' border-transparent text-sm font-medium leading-5 text-light-text hover:text-light-text hover:border-light focus:outline-none focus:text-light-text focus:border-light transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes" class="inline-flex items-center px-1 pt-1 border-b-2">
    <slot />
    </Link>
</template>
