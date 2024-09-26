<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col sm:justify-center items-center ">

        <div class="w-full h-full  px-6">
            <slot />
        </div>
    </div>
</template>
