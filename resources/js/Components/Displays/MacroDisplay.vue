<script setup>
import { computed } from "vue";


const props = defineProps(['account', 'calorieDay']);

console.log(props.calorieDay)

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
})

</script>


<template>
  <div class="bg-main border border-light rounded px-3 py-1">
    <div class="font-bold">Macros</div>
    <div v-for="macro, index in account.macros" class="grid grid-cols-6 text-xs">

      <span class="col-span-2 sm:col-span-3 font-bold uppercase">
        {{ index }}
      </span>

      <span class="text-center">
        <p>{{ calorieDayMacros[index] / macro * 100 }}%</p>
      </span>

      <span class="text-center">
        <p>{{ calorieDayMacros[index] }}</p>
      </span>

      <span class="col-span-2 sm:col-span-1 text-end">
        <p>{{ macro }} Goal</p>
      </span>

    </div>
  </div>
</template>