<script setup>
import { Head } from "@inertiajs/vue3";
import PageLayout from "./PageLayout.vue";
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
  <div class="relative flex flex-col bg-gradient-to-b from-light from-1% via-main via-50% to-light to-99% min-h-screen"
    style="scrollbar-gutter: stable;">
    <nav class="sticky top-0 z-20 shadow-xl">
      <GuestNav v-if="!$page.props.auth.user?.name" :canLogin="canLogin" :canRegister="canRegister" />
      <AuthenticatedNav v-else></AuthenticatedNav>
    </nav>

    <Head :title="$props.head" content="description required" :head-key="$props.head" />

    <header class="bg-neutral text-text-light shadow" v-if="$slots.header">
      <div class="flex justify-between space-x-3 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
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

    <footer>
      <div class="bg-dark mt-10 text-center py-12 font-bold text-xl text-text-light">
        Footer
      </div>
    </footer>
  </div>


</template>


<style lang="scss" scoped></style>