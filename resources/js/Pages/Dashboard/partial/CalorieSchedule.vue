<script setup>

const props = defineProps(['account', 'foodItems'])
</script>


<template>
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Calorie Schedule
    </h1>
    <h2>
      Designate where you would like your calories to go.
    </h2>
    <div>Find Meals that work for you.</div>
    <!-- {{ account }}
    {{ foodItems }} -->
  </div>
</template>


<style lang="scss" scoped></style>