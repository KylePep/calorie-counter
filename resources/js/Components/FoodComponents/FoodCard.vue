<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import FoodCardButton from "./FoodCardButton.vue";
import Pop from "@/utils/Pop.js";

const props = defineProps(['foodItem', 'calorieDay']);
const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}

const page = usePage();
const isDashboard = page.url.includes('dashboard');
const isCalorieDay = page.url.includes('calorie-day');

function useItem() {

  const protein = props.foodItem.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
  const carbohydrates = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
  const fats = props.foodItem.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

  const useItemForm = useForm({
    count: props.foodItem.calories,
    food_items: [{
      description: props.foodItem.description,
      count: props.foodItem.calories,
      protein: protein.value,
      carbohydrates: carbohydrates.value,
      fats: fats.value
    }]
  });

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



</script>

<template>
  <div :style="{ backgroundImage: 'url(' + foodItem.photo + ')' }"
    :class="foodItem.photo ? 'text-white' : 'text-dark-text'"
    class="group flex flex-col h-full w-32 sm:w-52 drop-shadow-lg bg-center bg-cover rounded hover:text-light-text duration-300">

    <section :class="foodItem.photo ? 'bg-gradient-to-b from-black to-transparent' : ''"
      class="flex flex-col flex-1  group-hover:bg-dark/90 rounded-t duration-300">

      <div class="flex  justify-between items-end sm:py-1 px-1 sm:px-2 rounded-t border border-b-0 border-light">

        <div class="font-bold ">
          {{ foodItem.calories }}
        </div>

        <div class="flex space-x-2">
          <FoodCardButton v-if="isDashboard || isCalorieDay" @click.stop="useItem()" icon="plus">
            Add
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard && !isCalorieDay && page.url != '/'" @click.stop="deleteItem()"
            icon="delete">Delete
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard && page.url == '/'" icon="signUp">
          </FoodCardButton>
        </div>

      </div>

      <button @click="setActive(foodItem)" class="flex-1 py-1 px-2 sm:p-3 border-x border-light">
        <h1 class="text-xs sm:text-sm truncate sm:text-balance text-shadow-lg font-bold ">{{
          foodItem.description }}
        </h1>
      </button>

    </section>

    <section :class="foodItem.photo ? 'bg-gradient-to-t from-black to-transparent' : ''"
      class="grid grid-cols-10 gap-0.5 p-1  group-hover:bg-dark/90 duration-300 border border-t-0 border-light rounded-b">
      <div v-for="block in Math.ceil(foodItem.calories / 100) " title="100 Calories"
        class="h-3 border border-light rounded-sm" :class="blockClass(block)">
      </div>
    </section>
  </div>

</template>
