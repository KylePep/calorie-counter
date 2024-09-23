<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- <div>
            <Link href="/">
            <ApplicationLogo class="block w-auto fill-current text-black/50 text-9xl " />
            </Link>
        </div> -->

        <div class="w-full h-full sm:max-w-4xl mt-6 px-6 py-4">
            <slot />
        </div>
    </div>
</template>
