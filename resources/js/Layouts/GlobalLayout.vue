<script setup>
import NavBar from "@/Components/NavBar.vue";
import { Head } from "@inertiajs/vue3";

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
    <nav class="sticky top-0 z-10 bg-white shadow-xl mb-10">
      <NavBar v-if="$page.url == '/' || $page.url == '/calculator'" :canLogin="canLogin" :canRegister="canRegister" />
    </nav>

    <header>

      <Head :title="$props.head" />
    </header>

    <main class="flex-1">
      <slot />
    </main>

    <footer>
      <div class="border-t-2  border-black/25 ms-10 me-8 text-center py-4 font-bold text-xl text-black/25">
        Footer
      </div>
    </footer>
  </div>


</template>


<style lang="scss" scoped></style>