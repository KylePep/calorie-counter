<script setup>
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";
import { computed } from "vue";

const mockItem = { "id": 1, "fdcId": null, "description": "Mega PB&J", "calories": 500, }
const mockItem2 = { "id": 2, "fdcId": null, "description": "Fried Egg", "calories": 100, }

const mockList = [{ "description": "Mega PB&J", "count": 500 }, { "description": "Fried Egg", "count": 100 }, { "description": "Fried Egg", "count": 100 }]

const firstRow = computed(() => mockList.filter((_, index) => index % 2 === 0));
const secondRow = computed(() => mockList.filter((_, index) => index % 2 === 1));

function representativeWidth(item) {

  const calorieBy100 = Math.round(item.count / 100) * 100;
  return {
    0: 'w-10',
    100: 'w-20',
    200: 'w-32',
    200: 'w-40',
    400: 'w-56',
    500: 'w-40',
    600: 'w-60',
    700: 'w-72',
    800: 'w-80',
    900: 'w-90',
    1000: 'w-100',
  }[calorieBy100];
}

// Function to return animation class based on conditions
const getAnimationClass = (item) => {
  const textWidth = item.description.length;
  const calorieWidth = Number(representativeWidth(item).split('-')[1]);

  if (textWidth > calorieWidth) {
    return 'animate-infinite-scroll';
  }
  return '';
}

</script>


<template>
  <div class="relative border-b-4 border-neutral-text w-48 mx-auto mb-10">
    <h2 class="absolute inset-x-0 -top-3 mx-8 text-neutral-text text-center font-bold bg-page"> FEATURE #3
    </h2>
  </div>

  <h3 class="capitalize text-neutral-text text-3xl font-bold">Unique and reactive feedback</h3>
  <div class=" grid grid-cols-2 gap-4 mt-4 shadow-xl">
    <div class="col-span-2">
      <div class="flex flex-col h-full text-start ">
        <div class="px-4 py-2 bg-neutral text-sm lg:text-base  text-light-text rounded-t ">
          <p>While tracking your calories, each square will represent 100 calories.</p>
          <p>Squares within your goal's range have a special border. </p>
          <p>Meaning you'll have a better representation of how much a single food item impacts
            your
            diet.</p>
        </div>

        <div class="mt-4 px-2">
          <p class="text-neutral-text text-center text-xl font-bold">Goal:1600, BMR: 1800</p>
          <div
            class="grid grid-cols-10 gap-1 text-transparent sm:text-neutral px-1.5 py-0.5 rounded ring-1 ring-main ring-inset border-2  border border-light drop-shadow-xl bg-gradient-to-b from-main via-light to-light">
            <div v-for="index in 20" class="flex flex-col justify-center items-center h-10 sm:h-14 border"
              :class="index < 8 ? 'bg-accent border-neutral' : '', index >= 8 && index <= 16 ? ' border-neutral ' : '', index > 16 && index <= 18 ? 'border-4 border-accent-light ' : '', index > 18 ? 'border-1 bg-neutral border-dark' : ''">
              {{ index >= 8 && index <= 18 ? '100' : '' }} </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-span-2 sm:col-span-1 order-1 sm:order-1">
        <p class="px-4 py-2 bg-neutral text-sm lg:text-base  text-light-text text-start h-full">
          Higher calorie foods will
          appear larger
          compared to other foods in your
          records
          for the
          day.
        </p>

      </div>

      <div class="col-span-2 sm:col-span-1 order-3 sm:order-2">
        <p class="px-4 py-2 bg-neutral text-sm lg:text-base text-light-text text-start h-full">Selecting
          foods from the
          USDA's
          database
          or from your saved or
          created
          lists
          will have a
          preview
          of how much room they'll take.
        </p>
      </div>

      <div class="col-span-2 sm:col-span-1 flex flex-col mb-2 order-2 sm:order-3 px-2">
        <div class="border-2 rounded border-neutral bg-light overflow-x-auto h-full">
          <div class=" p-2 grid grid-rows-2 text-center  whitespace-nowrap gap-1 ">
            <div v-for="rowIndex in 2" class="flex space-x-1">
              <div v-for="(item, index) in rowIndex == 1 ? firstRow : secondRow" :key="index"
                :class="representativeWidth(item)" :title="`${item.description}  -${item.count} Calories`"
                class="h-8 inline-block bg-main border border-light rounded-sm px-2 flex items-center justify-center duration-500 overflow-hidden shadow-lg">

                <p ref="scrollingText" :class="getAnimationClass(item)"
                  class="text-neutral-text text-xs ps-3 font-bold duration-400">
                  {{ item.description }}
                </p>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-span-2 sm:col-span-1 order-4 sm:order-4 px-2">
        <div class="flex overflow-x-auto mb-2">
          <div class="flex space-x-4">
            <FoodCard :foodItem="mockItem" />
            <FoodCard :foodItem="mockItem2" />
          </div>
        </div>
      </div>
    </div>
</template>