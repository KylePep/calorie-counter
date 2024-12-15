<script setup>
import CalorieDisplay from "@/Components/FoodComponents/CalorieDisplay.vue";
import { Link } from "@inertiajs/vue3";


const props = defineProps(['account', 'calorieDay']);
</script>


<template>
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Calorie Counter
    </h1>
    <div
      class="grid grid-cols-3 xl:grid-cols-4 font-bold text-xs xl:text-base text-neutral-text text-center bg-main border border-light border-b-0 rounded-t px-1 sm:px-3 py-1 uppercase">
      <p class="col-span-3 xl:col-span-1">
        Today: {{ new Date().toLocaleDateString() }}
      </p>
      <p>
        calories:
        {{ props.calorieDay.count }}
      </p>
      <p>
        Goal:
        {{ props.account.goal }}
      </p>
      <p>
        BMR:
        {{ props.calorieDay.bmr }}
      </p>
    </div>
    <Link :href="route('calorieDay.index')" class="w-full">
    <CalorieDisplay v-if="props.account" :goal="props.account.goal" :calorieCount="props.calorieDay.count"
      :bmr="props.calorieDay.bmr" />
    </Link>
  </div>
</template>


<style lang="scss" scoped></style>