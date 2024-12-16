<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import FoodItemSearch from "@/Components/FoodComponents/FoodItemSearch.vue";


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

    <CalorieRatioSelector :account />

    <FoodItemRatioResults bgColor="bg-accent-light/50">Breakfast</FoodItemRatioResults>
    <FoodItemRatioResults bgColor="bg-accent/50">Lunch</FoodItemRatioResults>
    <FoodItemRatioResults bgColor="bg-accent-dark/50">Dinner</FoodItemRatioResults>
    <FoodItemRatioResults bgColor="bg-special/50">Snack</FoodItemRatioResults>
    <FoodItemRatioResults bgColor="bg-special/50">Beverage</FoodItemRatioResults>

    <div>
      Find Meals that work for you.
    </div>

    <div>
      Based on the ratios derived from your goal/bmr you can then search for food items from the apps ecosystem to help
      meet your goals.
    </div>
    <FoodItemSearch />
  </div>
</template>


<style lang="scss" scoped></style>