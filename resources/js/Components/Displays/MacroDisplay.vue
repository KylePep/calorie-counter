<script setup>
import { computed } from "vue";


const props = defineProps(['account', 'calorieDay']);

const mockMacros = [{ "description": "Mega PB&J", "cal": 500, "protein": 15, 'carbohydrates': 5, 'fats': 3 }, { "description": "Mega PB&J", "cal": 500, "protein": 15, 'carbohydrates': 5, 'fats': 3 }];

const calorieDayMacros = computed(() => {
  let protein = 0;
  mockMacros.forEach(m => {
    protein += m.protein;
  });
  let carbohydrates = 0;
  mockMacros.forEach(m => {
    carbohydrates += m.carbohydrates;
  });
  let fats = 0;
  mockMacros.forEach(m => {
    fats += m.fats;
  });

  return { protein, carbohydrates, fats }
})

</script>


<template>
  <div class="bg-main border border-light rounded px-3 py-1">
    <div class="font-bold">Macros</div>
    <div v-for="macro, index in account.macros" class="grid grid-cols-6 text-xs">

      <span class="col-span-3 font-bold uppercase">
        {{ index }}
      </span>

      <span class="">
        <p>{{ calorieDayMacros[index] / macro * 100 }}%</p>
      </span>

      <span class="">
        <p>{{ calorieDayMacros[index] }}</p>
      </span>

      <span>
        <p>{{ macro }} Goal</p>
      </span>

    </div>
  </div>
</template>