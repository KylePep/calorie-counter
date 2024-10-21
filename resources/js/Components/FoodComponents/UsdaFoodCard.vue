<script setup>
import { usePage } from "@inertiajs/vue3";
import UsdaFoodCardButton from "./UsdaFoodCardButton.vue";

const emit = defineEmits(['increase-by', 'extraButton'])

const props = defineProps(['foodItem']);

const page = usePage();
const isDashboard = page.url.includes('dashboard')

function emitIncreaseBy(item) {
  if (item.gtinUpc) {
    item.calories = getBrandedCalories(item)
  } else {
    item.calories = getCalories(item)
  }
  emit('increase-by', item);
}

function emitExtraButton(item, action) {
  if (item.gtinUpc) {
    item.calories = getBrandedCalories(item)
  } else {
    item.calories = getCalories(item)
  }
  emit('extraButton', item, action);
}

const getCalories = (item) => {
  const energy = item.foodNutrients.find(fn => fn.nutrientName == 'Energy' && fn.unitName == 'KCAL');
  if (!energy) {
    return 0
  }
  return energy.value;
}

const getBrandedCalories = (item) => {
  const energy = getCalories(item);
  const caloriesToSize = energy * (item.servingSize * .01);
  return Math.round(caloriesToSize);
}

</script>


<template>

  <section class="flex flex-col break-inside-avoid bg-gray-300  rounded border-2 border-neutral h-full min-h-40">

    <div class="flex items-center justify-between bg-gray-200 p-1 px-2 border-b-2 border-neutral">

      <div class=" text-text font-bold text-3xl drop-shadow-2xl">
        <template v-if="foodItem.gtinUpc != 0">
          {{ getBrandedCalories(foodItem) }}
        </template>
        <template v-else>
          {{ getCalories(foodItem) }}
        </template>
      </div>

      <div class="flex space-x-3">
        <UsdaFoodCardButton v-if="isDashboard" @click.stop="emitIncreaseBy(foodItem)" icon="plus">Add
        </UsdaFoodCardButton>
        <UsdaFoodCardButton @click.stop="emitExtraButton(foodItem, 'favorite')" icon="star">Favorite
        </UsdaFoodCardButton>
      </div>

    </div>

    <div @click="emitExtraButton(foodItem, 'edit')" :title="'Edit'"
      class="flex-1 flex flex-col justify-center items-center text-text-light hover:text-dark bg-neutral hover:bg-light hover:cursor-pointer px-3 drop-shadow-xl my-auto duration-300">
      <h1 class="font-bold text-balance truncate" :class="[foodItem.gtinUpc ? 'text-base' : 'text-lg']">{{
        foodItem.description
      }}
      </h1>
      <p class="text-xs" v-if="foodItem.gtinUpc && foodItem.brandOwner">
        ( {{ foodItem.brandName + [foodItem.brandName ? ' by' : ''] }} {{ foodItem.brandOwner }} )
      </p>

    </div>

    <div class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-1 p-1 border-t-2 border-neutral bg-dark shadow-lg">
      <div v-for="block in Math.round([foodItem.gtinUpc ? getBrandedCalories(foodItem) : getCalories(foodItem)] / 50) "
        class="bg-accent h-4 border-2  border-neutral rounded-sm" title="50 Calories">
      </div>
    </div>

  </section>

</template>
