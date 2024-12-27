<script setup>
import { computed } from "vue";

const props = defineProps(['foodItem', 'calorieDay', 'isSearchResult']);
const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}

const protein = props.foodItem.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
const carbohydrates = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
const fats = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

const foodQualities = computed(() => {
  if (!props.foodItem.qualities) {
    return []
  } else {
    const trimmedStr = props.foodItem.qualities.replace(/,+$/, "");
    return trimmedStr.split(',')
  }
})

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

function foodCategoryColoring() {
  return {
    breakfast: 'border-accent-light',
    lunch: 'border-accent',
    dinner: 'border-accent-dark',
    beverage: 'border-special',
    snack: 'border-special'
  }[props.foodItem.foodCategory]
}



</script>

<template>
  <div :style="{ backgroundImage: 'url(' + foodItem.photo + ')' }"
    :class="[foodItem.photo ? 'text-white' : 'text-dark-text', foodCategoryColoring()]"
    class="group flex flex-col h-full hover:text-white border-4 hover:border-dark drop-shadow-lg bg-center bg-cover rounded-lg duration-300">

    <section :class="foodItem.photo ? 'bg-gradient-to-b from-black to-transparent' : ''"
      class="flex flex-col flex-1  group-hover:bg-dark/90 rounded-t duration-300 py-1">

      <div class="flex justify-between items-end sm:py-1 px-2 rounded-t">

        <div class="font-bold">
          {{ foodItem.calories }} Cal
        </div>

      </div>

      <div class="flex justify-around items-end py-2 px-2">
        <div v-if="protein.value > 0" class="font-bold text-sm">
          {{ protein.value }}g Protein
        </div>
        <div v-if="fats.value > 0" class="font-bold text-sm">
          {{ fats.value }}g Fats
        </div>
        <div v-if="carbohydrates.value > 0" class="font-bold text-sm">
          {{ carbohydrates.value }}g Carbs
        </div>
      </div>

      <button @click="setActive(foodItem)" class="flex-1 py-4 px-2">
        <h1 :class="foodItem.photo ? 'radial-gradient' : ''" class="lg:text-lg truncate font-bold px-1 py-2">
          {{ foodItem.description }}
        </h1>
      </button>

      <div class="flex justify-around items-end py-2 px-2 text-sm">
        <div v-for="quality in foodQualities" class="capitalize">
          {{ quality }}
        </div>
      </div>

    </section>

    <section :class="foodItem.photo ? 'bg-gradient-to-t from-black to-transparent' : ''"
      class="grid grid-cols-10 gap-0.5 p-2  group-hover:bg-dark/90 duration-300 rounded-b">
      <div v-for="block, index in Math.ceil(foodItem.calories / 100)" :key="index" title="100 Calories"
        class="h-3 border border-light rounded-sm" :class="blockClass(block)">
      </div>
    </section>
  </div>

</template>

<style>
.radial-gradient {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(5px);
}
</style>
