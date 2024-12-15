<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);
</script>

<template>
  <GlobalLayout head="Dashboard">

    <template #header>
      Dashboard
    </template>

    <div class="min-h-screen flex flex-col justify-between space-y-60 lg:space-y-80 my-80 lg:my-48">

    </div>

  </GlobalLayout>
</template>