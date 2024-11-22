<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-light to-main border border-light rounded font-bold text-xs text-dark-text uppercase tracking-widest hover:from-main hover:to-main focus:from-main focus:to-main active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-light/20">
        <slot />
    </button>
</template>
