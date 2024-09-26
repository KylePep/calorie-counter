<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "./GuestLayout.vue";
import GuestNav from "@/Components/GuestNav.vue";
import AuthenticatedNav from "@/Components/AuthenticatedNav.vue";

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
})
</script>


<template>
  <div class="relative flex flex-col bg-gray-100 min-h-screen" style="scrollbar-gutter: stable;">
    <nav class="sticky top-0 z-10 bg-white shadow-xl">
      <GuestNav v-if="!$page.props.auth.user?.name" :canLogin="canLogin" :canRegister="canRegister" />
      <AuthenticatedNav v-else></AuthenticatedNav>
    </nav>

    <Head :title="$props.head" content="description required" :head-key="$props.head" />

    <header class="bg-white shadow" v-if="$slots.header">
      <div class="flex space-x-3 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
    </header>

    <main class="flex-1 mt-10">
      <GuestLayout>
        <slot></slot>
      </GuestLayout>
    </main>

    <footer>
      <div class="border-t-2  border-black/25 ms-10 mt-10 me-8 text-center py-4 font-bold text-xl text-black/25">
        Footer
      </div>
    </footer>
  </div>


</template>


<style lang="scss" scoped></style>