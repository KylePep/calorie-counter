<script setup>
import { computed, ref } from "vue";
import CollapsableFolder from "./CollapsableFolder.vue";


const props = defineProps(['account', 'calorieDay']);

const displayList = ref(false);

const sortedFoodItems = computed(() => {
  return (key) => {
    return [...props.calorieDay.food_items].sort((a, b) => b[key] - a[key]);
  };
})

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

  <div>
    <CollapsableFolder>
      <template #title>
        <p>
          Macros
        </p>
      </template>

      <template #config>
        <button @click="displayList = !displayList"
          class="bg-accent hover:bg-dark text-dark-text hover:text-light-text rounded-md px-3 ">
          <i :class="displayList ? 'mdi mdi-card-text' : 'mdi mdi-format-list-bulleted'"></i>
        </button>
      </template>

      <template #content>
        <div v-if="!displayList">
          <div v-for="macro, index in account.macros" class="relative bg-main h-6 my-1">

            <div class="absolute h-full rounded-sm" :class="macroClass(index)"
              :style="{ width: `${Math.min(calorieDayMacros[index] / macro * 100, 100)}%` }">
            </div>

            <div class="absolute w-full h-full grid grid-cols-6 border border-neutral rounded-sm p-1 text-xs">
              <span class="col-span-2 sm:col-span-3 font-bold uppercase">
                {{ index }}
              </span>

              <span class="text-center">
                <p>{{ Math.round(calorieDayMacros[index] / macro * 100) }}%</p>
              </span>

              <span class="text-center">
                <p>{{ Math.round(calorieDayMacros[index]) }}g</p>
              </span>

              <span class="col-span-2 sm:col-span-1 text-end">
                <p>{{ macro }}g Goal</p>
              </span>
            </div>

          </div>
        </div>
        <div v-else class="grid grid-cols-1 gap-4">
          <div v-for="macro, index in account.macros">
            <h1 class="font-bold text-sm">
              <span class="uppercase">{{ index }}</span>
              - {{ macro }}g - {{ Math.round(calorieDayMacros[index]) }}g -{{
                Math.round(calorieDayMacros[index] / macro * 100) }}%
            </h1>
            <div v-for="item, i in sortedFoodItems(index)" :class="macroClass(index)"
              class="grid grid-cols-5 text-xs text-center px-1 py-0.5 my-1">
              <span class="col-span-3 text-start pe-2  truncate">{{ i + 1 }}. {{ item.description }}</span>
              <span>{{ item[index] }}</span>
              <span>{{ Math.round(item[index] / macro * 100) }}%</span>

            </div>
          </div>
        </div>
      </template>
    </CollapsableFolder>
  </div>

</template>