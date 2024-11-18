<script setup>
import { usePage } from "@inertiajs/vue3";
import FoodCardButton from "./FoodCardButton.vue";
import { computed } from "vue";

const props = defineProps(['foodItem']);
const emit = defineEmits(['itemActivated', 'extraButton']);

const page = usePage();
const isDashboard = page.url.includes('dashboard');
const isCalorieDay = page.url.includes('calorie-day');

function emitExtraButton(item, action) {
  const protein = item.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
  const carbohydrates = item.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
  const fats = item.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

  const modifiedItem = item
  modifiedItem.count = item.calories
  modifiedItem.protein = protein
  modifiedItem.carbohydrates = carbohydrates
  modifiedItem.fats = fats
  emit('extraButton', modifiedItem, action);
}

function blockClass(block) {
  const blockCalorie = props.foodItem.calories - (block * 100);

  if (blockCalorie >= 0) {
    return 'bg-accent-dark'
  } else if (blockCalorie >= -50) {
    return 'bg-accent'
  } else {
    return 'bg-accent-light'
  }
}

</script>

<template>

  <div
    class="flex flex-col h-full w-32 sm:w-52 drop-shadow-lg bg-white rounded hover:bg-dark hover:text-light-text duration-300">

    <section class="flex flex-col flex-1  ">

      <div class="flex  justify-between items-end py-1 px-2 rounded-t border border-b-0 border-light">

        <div class="font-bold ">
          {{ foodItem.calories }}
        </div>

        <div class="flex space-x-2">
          <FoodCardButton v-if="isDashboard || isCalorieDay" @click.stop="emitExtraButton(foodItem, 'add')" icon="plus">
            Add
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard && !isCalorieDay && page.url != '/'"
            @click.stop="emitExtraButton(foodItem, 'delete')" icon="delete">Delete
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard && page.url == '/'" icon="signUp">
          </FoodCardButton>
        </div>

      </div>

      <button @click="emitExtraButton(foodItem, 'edit')" class="flex-1 py-1 px-2 sm:p-3 border-x border-light">
        <h1 class="text-xs sm:text-sm truncate sm:text-balance font-bold">{{ foodItem.description }}
        </h1>
      </button>

    </section>

    <section class="grid grid-cols-10 gap-0.5 p-1 border border-t-0 border-light rounded-b">
      <div v-for="block in Math.ceil(foodItem.calories / 100) " title="100 Calories"
        class="h-3 border border-light rounded-sm" :class="blockClass(block)">
      </div>
    </section>
  </div>

</template>
