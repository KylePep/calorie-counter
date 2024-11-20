<script setup>
import { computed, ref } from "vue";
import Dropdown from "../Form/Dropdown.vue";
import FoodCardButton from "../FoodComponents/FoodCardButton.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps(['list']);

const page = usePage();
const isDashboard = page.url.includes('dashboard');
const isCalorieDay = page.url.includes('calorie-day');
const filter = ref('All');

const filteredList = computed(() => {
  if (filter.value != 'All') {
    return props.list.filter((li) => li.foodCategory == filter.value.toLocaleLowerCase());
  } else return props.list;
});

function addFoodItem(foodItem) {

};

function deleteFoodItem(foodItem) {

};


</script>



<template>
  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Your Foods</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">
      Filter and search your foods.
    </h2>

    <section>
      <div class="col-span-3 sm:col-span-2 flex items-center">
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
            <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs">
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
      </div>
    </section>

    <section class=" " :class="currentSizeClass">

      <div v-for="foodItem in filteredList">
        <div class="grid grid-cols-8 min-h-8 bg-white border border-light rounded text-xs p-2 ps-0 sm:ps-2 my-1">

          <div>
            <FoodCardButton v-if="isDashboard || isCalorieDay" @click.stop="addFoodItem(foodItem)" icon="plus">
              Add
            </FoodCardButton>
            <FoodCardButton v-if="!isDashboard && !isCalorieDay && page.url != '/'"
              @click.stop="deleteFoodItem(foodItem)" icon="delete">Delete
            </FoodCardButton>
          </div>

          <div class="col-span-6 flex flex-col sm:flex-row space-x-2 ps-2">
            <div class="truncate text-sm">
              {{ foodItem.description }}
            </div>
            <div class="">{{ foodItem.foodCategory }} - {{ foodItem.servingSize }}{{ foodItem.servingSizeUnit }}</div>
          </div>

          <div class="col-span-1 text-end my-auto">{{ foodItem.calories }} cal</div>
        </div>
      </div>

      <div v-if="filteredList.length == 0"
        class="justify-center w-full text-center text-light-text text-xs bg-neutral py-2">
        <p>
          No foods to show
        </p>
      </div>
    </section>
  </div>

</template>