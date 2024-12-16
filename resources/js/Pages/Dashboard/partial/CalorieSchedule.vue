<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import UsdaSearch from "@/Components/FoodComponents/UsdaSearch.vue";


const props = defineProps(['account', 'foodItems'])
</script>


<template>
  <div class="text-neutral-text p-4 lg:p-8 space-y-8">

    <h1 class="text-2xl font-bold  mb-3">
      Calorie Schedule
    </h1>

    <h2>
      Designate where you would like your calories to go.
    </h2>



    <div>
      Decide and set calorie ratios - Breakfast, Lunch, Dinner, Snack (Beverage)
    </div>

    <CalorieRatioSelector />

    <div>
      Find Meals that work for you.
    </div>

    <div>
      Based on the ratios derived from your goal/bmr you can then search for food items from the apps ecosystem to help
      meet your goals.
    </div>
    <UsdaSearch />
  </div>
</template>


<style lang="scss" scoped></style>