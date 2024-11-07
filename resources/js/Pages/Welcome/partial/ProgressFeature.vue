<script setup>
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";

const mockItem = { "id": 1, "fdcId": null, "description": "Mega PB&J", "calories": 500, }
const mockItem2 = { "id": 2, "fdcId": null, "description": "Fried Egg", "calories": 100, }

const mockList = [{ "description": "Mega PB&J", "count": 500 }, { "description": "Fried Egg", "count": 100 }, { "description": "Fried Egg", "count": 100 }]
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

        <div class="mt-4">
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

      <div>
        <p class="px-4 py-2 bg-neutral text-sm lg:text-base  text-light-text h-full">
          Higher calorie foods will
          appear larger
          compared to other foods in your
          records
          for the
          day.
        </p>

      </div>

      <div>
        <p class="px-4 py-2 bg-neutral text-sm lg:text-base text-light-text h-full">Selecting foods from the
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

      <div class="flex flex-col justify-end">
        <div class="border-2 rounded border-neutral bg-light">
          <ConsumedList :dayItems="mockList" />
        </div>
      </div>

      <div>
        <div class="flex w-full overflow-x-auto">
          <FoodCard :foodItem="mockItem" />
          <FoodCard :foodItem="mockItem2" />
        </div>
      </div>
    </div>
</template>