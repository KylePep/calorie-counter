<script setup>
import CalculateBanner from "@/Components/CalculateBanner.vue";
import AuthenticatedNav from "@/Components/Nav/AuthenticatedNav.vue";
import GuestNav from "@/Components/Nav/GuestNav.vue";
import { Head, usePage } from "@inertiajs/vue3";
import FooterContent from "./Partials/FooterContent.vue";
import { onMounted, onUnmounted, ref } from "vue";

const props = defineProps(['canLogin', 'canRegister', 'head', 'heroImage', 'heroHeight']);

const { props: pageProps } = usePage();
const theme = pageProps.auth?.account?.theme ?? 'theme-sunRise';
document.body.setAttribute('body-theme', theme);

const isAtTop = ref(true);

const handleScroll = () => {
  isAtTop.value = Math.round(window.scrollY == 0);
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
});

</script>


<template>
  <div class="relative flex flex-col bg-page min-h-screen" style="scrollbar-gutter: stable;">
    <nav class="fixed top-0 z-20 w-full">
      <GuestNav v-if="!$page.props.auth?.user?.name" :canLogin="canLogin" :canRegister="canRegister" />
      <AuthenticatedNav :header="props.head" v-else></AuthenticatedNav>
    </nav>

    <Head :title="$props.head" content="description required" :head-key="$props.head" />

    <header class=" bg-neutral shadow-xl" v-if="$slots.header">

      <div v-if="heroImage" class="flex justify-center items-center h-96 space-x-3 mx-auto py-6 px-4 sm:px-6 lg:px-8 "
        :style="{ backgroundImage: `linear-gradient(to top, rgba(var(--hero-gradient), 0) 10%, rgba(var(--hero-gradient), 0.5) 80%, rgba(var(--hero-gradient), 0.6) 100%), url(${heroImage})`, backgroundPosition: `50% ${heroHeight}%`, backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }">
        <div
          class="font-semibold text-6xl sm:text-7xl leading-tight text-shadow-2xl text-white text-center sm:text-start">
          <slot name="header"></slot>
        </div>
      </div>

      <div v-else
        class="h-32 lg:h-32 flex justify-center items-end font-semibold text-xl leading-tight space-x-3 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 uppercase duration-1000"
        :class="isAtTop ? 'text-white' : 'text-transparent'">
        <slot name="header"></slot>
      </div>


      <CalculateBanner position="header" />

    </header>

    <main class="grid grid-cols-4 flex-1 mt-10 lg:mt-14">


      <div class="col-span-4 lg:col-span-1 mb-3 lg:mb-0">
        <div v-if="$slots.leftSide" class="sticky top-32 px-6 lg:px-4">
          <slot name="leftSide" />
        </div>
      </div>

      <section class="col-span-4 lg:col-span-2">
        <div class="space-y-4 max-w-7xl mx-auto px-6 lg:px-8">
          <slot />
        </div>
      </section>

      <div class="col-span-4 lg:col-span-1 mt-3 sm:mt-0">
        <div v-if="$slots.rightSide" class="sticky top-32 px-6 lg:px-4">
          <slot name="rightSide" />
        </div>
      </div>
    </main>

    <footer class="mt-20">
      <CalculateBanner position="footer" />
      <FooterContent class="hidden sm:grid" />
    </footer>
  </div>

</template>