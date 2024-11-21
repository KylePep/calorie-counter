<script setup>
import { computed, ref } from "vue";


const props = defineProps(['account', 'calorieDay']);


const macros = computed(() => {
  return Object.fromEntries(
    Object.entries(props.account.macros).filter(([key, value]) => value > 0)
  );
});

const calorieDayMacros = computed(() => {
  let protein = 0;
  props.calorieDay.food_items.forEach(m => {
    protein += m.protein;
  });
  let carbohydrates = 0;
  props.calorieDay.food_items.forEach(m => {
    carbohydrates += m.carbohydrates;
  });
  let fats = 0;
  props.calorieDay.food_items.forEach(m => {
    fats += m.fats;
  });

  return { protein, carbohydrates, fats }
});

function macroClass(index) {
  return {
    protein: 'bg-accent/50',
    carbohydrates: 'bg-accent-dark/50',
    fats: 'bg-accent-light/50'
  }[index]
};

</script>


<template>

  <div class="grid grid-cols-3 gap-x-2">
    <div v-for="macro, index in macros" class="relative bg-white h-6">

      <div class="absolute h-full rounded-md" :class="macroClass(index)"
        :style="{ width: `${Math.min(calorieDayMacros[index] / macro * 100, 100)}%` }">
      </div>


      <div class="absolute w-full h-full grid grid-cols-6 text-neutral-text border border-light rounded-md p-1 text-xs">

        <span class="text-start sm:text-center font-bold text-dark-text/75 col-span-4 sm:col-span-2">
          <p>{{ Math.round(calorieDayMacros[index] / macro * 100) }} %</p>
        </span>

        <span class="hidden sm:block text-center font-bold text-dark-text/50 col-span-2 ">
          <p>{{ Math.round(calorieDayMacros[index]) }}g</p>
        </span>

        <span class=" col-span-2 sm:col-span-2 text-end font-bold text-dark-text/50">
          <p>{{ macro }}g</p>
        </span>
      </div>

    </div>

    <div v-for="macro, index in macros" class="text-center text-xs font-bold text-dark-text/50 uppercase">
      {{ index }}
    </div>
  </div>

</template>