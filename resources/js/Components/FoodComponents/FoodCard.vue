<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import FoodCardButton from "./FoodCardButton.vue";
import Pop from "@/utils/Pop.js";

const props = defineProps(['foodItem', 'calorieDay', 'isSearchResult']);
const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}

const page = usePage();
const isDashboard = page.url.includes('dashboard');
const isCalorieDay = page.url.includes('calorie-day');

async function useItem() {

  const protein = props.foodItem.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
  const carbohydrates = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
  const fats = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

  const useItemForm = useForm({
    count: props.foodItem.calories,
    food_items: [{
      description: props.foodItem.description,
      category: props.foodItem.foodCategory,
      count: props.foodItem.calories,
      protein: Number(protein.value),
      carbohydrates: Number(carbohydrates.value),
      fats: Number(fats.value)
    }]
  });

  if (!props.calorieDay || !props.calorieDay.id) {
    console.error('CalorieDay ID is missing or invalid');
    return;
  }

  useItemForm.put(route('calorieDay.update', props.calorieDay.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`+ ${useItemForm.count} Calories`);
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

async function deleteItem() {
  const confirmDelete = await Pop.confirm(`Delete ${props.foodItem.description}?`)
  if (!confirmDelete) {
    return;
  }

  const form = useForm(props.foodItem);

  form.delete(route('foodItem.destroy', props.foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} deleted`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

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
  <div :style="{ backgroundImage: foodItem.photo ? 'url(' + foodItem.photo + ')' : '' }"
    :class="[foodItem.photo ? 'text-white' : 'text-dark-text', foodCategoryColoring()]"
    class="group flex flex-col h-full w-32 sm:w-52 hover:text-white border-4 hover:border-dark drop-shadow-lg bg-center bg-cover rounded-lg duration-300">

    <section :class="foodItem.photo ? 'bg-gradient-to-b from-black to-transparent' : ''"
      class="flex flex-col flex-1  group-hover:bg-dark/90 rounded-t duration-300 py-1">

      <div class="flex  justify-between items-end sm:py-1 px-1 sm:px-2 rounded-t">

        <div class="font-bold ">
          {{ foodItem.calories }}
        </div>

        <div v-if="!isSearchResult" class="flex space-x-2">
          <FoodCardButton v-if="isCalorieDay" @click.stop="useItem()" icon="plus">
            Add
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard && !isCalorieDay && page.url != '/'" @click.stop="deleteItem()"
            icon="delete">Delete
          </FoodCardButton>
        </div>

      </div>

      <button @click="setActive(foodItem)" class="flex-1 py-1 px-2 sm:p-3">
        <h1 :class="foodItem.photo ? 'radial-gradient' : ''"
          class="text-xs sm:text-sm truncate sm:text-balance font-bold px-1">
          {{
            foodItem.description }}
        </h1>
      </button>

    </section>

    <section :class="foodItem.photo ? 'bg-gradient-to-t from-black to-transparent' : ''"
      class="grid grid-cols-10 gap-0.5 p-1  group-hover:bg-dark/90 duration-300 rounded-b">
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
