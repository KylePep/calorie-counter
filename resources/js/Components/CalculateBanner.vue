<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps(['position']);

const page = usePage();

const topBannerPage = computed(() => {
  if (props.position == 'header') {
    const allowedTopPages = ['/'];
    return allowedTopPages.some(title => page.url == title);
  }
});

const bottomBannerPage = computed(() => {
  if (props.position == 'footer') {
    const allowedBottomPages = ['/', '/food', '/history'];
    return allowedBottomPages.some(title => page.url == title);
  }
})
</script>

<template>
  <div v-if="bottomBannerPage || topBannerPage"
    class="flex flex-col text-center justify-center items-center bg-gradient-to-r from-accent-red via-accent to-accent-yellow py-8 space-y-4">
    <p class="text-white text-sm font-bold">calorie calculation</p>
    <p class="text-white text-3xl">Use the calculator to set your goal</p>
    <Link :href="route('calculator')"
      class="text-base text-accent hover:text-accent-yellow font-bold uppercase bg-white px-28 sm:px-32 py-4 duration-300">
    get your bmr!
    </Link>
  </div>

</template>
