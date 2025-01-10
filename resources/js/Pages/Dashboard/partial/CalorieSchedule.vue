<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";

const props = defineProps(['account', 'foodItems', 'calorieDay']);


</script>


<template>
  <div class="text-neutral-text p-4 lg:px-8 lg:py-0">

    <h1 class="text-lg lg:text-2xl font-bold mb-3 bg-light px-2 py-1 rounded">
      Calorie Schedule
    </h1>

    <CalorieRatioSelector :account :calorieDay />

  </div>

</template>


<style lang="scss" scoped></style>