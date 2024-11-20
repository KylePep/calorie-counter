<script setup>
import { computed, ref } from "vue";
import Dropdown from "../Form/Dropdown.vue";
import FoodCardButton from "../FoodComponents/FoodCardButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import TextInput from "../Form/TextInput.vue";

const props = defineProps(['list', 'calorieDay']);

const page = usePage();
const isDashboard = page.url.includes('dashboard');
const isCalorieDay = page.url.includes('calorie-day');
const filter = ref('All');

const form = useForm({
  search: ''
})

const filteredList = computed(() => {
  return props.list
    .filter((li) => {
      return filter.value === 'All' || li.foodCategory === filter.value.toLowerCase();
    })
    .filter((li) => {
      return !form.search || li.description.toLowerCase().includes(form.search.toLowerCase());
    })
});

function useItem(foodItem) {

  const protein = foodItem.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
  const carbohydrates = foodItem.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
  const fats = foodItem.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

  const useItemForm = useForm({
    count: foodItem.calories,
    food_items: [{
      description: foodItem.description,
      count: foodItem.calories,
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

async function deleteItem(foodItem) {
  const confirmDelete = await Pop.confirm(`Delete ${foodItem.description}?`)
  if (!confirmDelete) {
    return;
  }

  const form = useForm(foodItem);

  form.delete(route('foodItem.destroy', foodItem.id), {
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


</script>



<template>
  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Your Foods</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">
      Filter and search your foods.
    </h2>

    <section class="grid lg:grid-cols-2 lg:gap-x-2 bg-light rounded p-1">

      <TextInput v-model="form.search" placeholder="Search by description" class="h-8 w-full" />

      <Dropdown align="left" width="100" class="w-full">

        <template #trigger>
          <button type="button"
            class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-dark-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">
            <p class="flex-1 flex items-center text-center">
              {{ filter }}
            </p>
            <i class="mdi mdi-menu-down text-lg"></i>
          </button>
        </template>

        <template #content>
          <div class="flex flex-col p-2 bg-light rounded text-dark-text text-xs">
            <button class="text-start p-1" :class="[filter == 'All' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'All'">All</button>
            <button class="text-start p-1" :class="[filter == 'Breakfast' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Breakfast'">Breakfast</button>
            <button class="text-start p-1" :class="[filter == 'Lunch' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Lunch'">Lunch</button>
            <button class="text-start p-1" :class="[filter == 'Dinner' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Dinner'">Dinner</button>
            <button class="text-start p-1" :class="[filter == 'Beverage' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Beverage'">Beverage</button>
            <button class="text-start p-1" :class="[filter == 'Snack' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Snack'">Snack</button>
          </div>
        </template>

      </Dropdown>

    </section>

    <section v-if="filteredList.length == 0"
      class="justify-center min-h-8 w-full text-center text-dark-text text-xs border border-light rounded py-2">
      <p>
        No foods to show
      </p>
    </section>

    <section v-else>

      <div v-for="foodItem in filteredList">
        <div class="grid grid-cols-10 min-h-8 bg-white border border-light rounded text-xs p-2 ps-0 sm:ps-2 my-1">

          <div class="col-span-1 text-start font-bold my-auto ps-2 tabular-nums">{{ foodItem.calories }} cal</div>

          <div class="col-span-7 grid grid-cols-4 ps-2">
            <div class="col-span-4 lg:col-span-3 truncate text-sm ">
              {{ foodItem.description }}
            </div>
            <div class="col-span-4 lg:col-span-1">{{ foodItem.foodCategory }} - {{ foodItem.servingSize }}{{
              foodItem.servingSizeUnit
            }}
            </div>
          </div>

          <div class="col-span-2 flex flex-col items-end">
            <FoodCardButton v-if="isDashboard || isCalorieDay" @click.stop="useItem(foodItem)" icon="plus">
              Add
            </FoodCardButton>
            <FoodCardButton v-if="!isDashboard && !isCalorieDay && page.url != '/'" @click.stop="deleteItem(foodItem)"
              icon="delete">Delete
            </FoodCardButton>
          </div>

        </div>
      </div>


    </section>
  </div>

</template>