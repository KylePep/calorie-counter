<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import PageLayout from "./PageLayout.vue";
import GuestNav from "@/Components/GuestNav.vue";
import AuthenticatedNav from "@/Components/AuthenticatedNav.vue";
import CalculateBanner from '../Components/CalculateBanner.vue'
import FooterContent from './FooterContent.vue'

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  head: {
    type: String,
  },
  heroImage: {
    type: String
  },
  heroHeight: {
    type: String
  }
})

const page = usePage();
</script>


<template>
  <div class="relative flex flex-col bg-page min-h-screen" style="scrollbar-gutter: stable;">
    <nav class="sticky top-0 z-20 shadow-xl">
      <GuestNav v-if="!$page.props.auth.user?.name" :canLogin="canLogin" :canRegister="canRegister" />
      <AuthenticatedNav v-else></AuthenticatedNav>
    </nav>

    <Head :title="$props.head" content="description required" :head-key="$props.head" />

    <header class="bg-neutral text-text-light shadow-xl" v-if="$slots.header">

      <div v-if="heroImage" class="flex justify-center items-center h-96 space-x-3 mx-auto py-6 px-4 sm:px-6 lg:px-8 "
        :style="{ backgroundImage: `linear-gradient(to top, rgba(0, 0, 0, 0) 10%, rgba(0, 0, 0, 0.5) 80%, rgba(0, 0, 0, 0.6) 100%), url(${heroImage})`, backgroundPosition: `50% ${heroHeight}%`, backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }">
        <div class="font-semibold text-7xl leading-tight text-shadow-2xl text-white text-center sm:text-start">
          <slot name="header"></slot>
        </div>

      </div>

      <div v-else class="flex justify-between space-x-3 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
      <CalculateBanner position="header" />

    </header>

    <main class="grid grid-cols-4 flex-1 mt-10">


      <div class="col-span-4 lg:col-span-1">
        <div v-if="$slots.leftSide" class="sticky top-16">
          <slot name="leftSide" />
        </div>
      </div>

      <PageLayout class="col-start-1 lg:col-start-2 col-span-4 lg:col-span-2">
        <slot />
      </PageLayout>

      <div class="col-span-4 lg:col-span-1  lg:col-start-4">
        <div v-if="$slots.rightSide" class="sticky top-16">
          <slot name="rightSide" />
        </div>
      </div>
    </main>

    <footer class="mt-20">
      <CalculateBanner position="footer" />
      <FooterContent />
    </footer>
  </div>


</template>


<style lang="scss" scoped></style>