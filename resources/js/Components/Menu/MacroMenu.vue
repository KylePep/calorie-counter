<script setup>
import { computed, ref } from "vue";


const props = defineProps(['account', 'calorieDay']);

const displayList = ref(false);

const macros = computed(() => {
  return Object.fromEntries(
    Object.entries(props.account.macros).filter(([key, value]) => value > 0)
  );
});

const sortedFoodItems = computed(() => {
  return (key) => {
    return [...props.calorieDay.food_items].sort((a, b) => b[key] - a[key]);
  };
})

const calorieDayMacros = computed(() => {
  let protein = 0;
  props.calorieDay.food_items.forEach(m => {
    protein += Number(m.protein);
  });
  let carbohydrates = 0;
  props.calorieDay.food_items.forEach(m => {
    carbohydrates += Number(m.carbohydrates);
  });
  let fats = 0;
  props.calorieDay.food_items.forEach(m => {
    fats += Number(m.fats);
  });

  return { protein, carbohydrates, fats }
});

function macroClass(index) {
  return {
    protein: 'bg-accent/20',
    carbohydrates: 'bg-accent-dark/20',
    fats: 'bg-accent-light/20'
  }[index]
};

</script>


<template>
  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Macro List</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">All of your foods for the day, arranged from highest to lowest
      macros.
    </h2>

    <div class="grid grid-cols-1 gap-1 sm:gap-4">
      <div v-for="macro, index in macros">
        <h1 class="font-bold text-sm">
          <span class="uppercase">{{ index }}</span>
          - {{ macro }}g - {{ Math.round(calorieDayMacros[index]) }}g -{{
            Math.round(calorieDayMacros[index] / macro * 100) }}%
        </h1>
        <div v-for="item, i in sortedFoodItems(index)" :class="macroClass(index)"
          class="grid grid-cols-5 text-xs text-center  px-1 py-0.5 my-1">
          <span class="col-span-3 text-start pe-2  truncate">{{ i + 1 }}. {{ item.description }}</span>
          <span>{{ item[index] }}g</span>
          <span>{{ Math.round(item[index] / macro * 100) }}%</span>

        </div>
      </div>
    </div>
  </div>
</template>