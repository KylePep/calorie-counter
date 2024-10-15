<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, reactive, ref } from "vue";
import { FoodSearchResponse } from "../../models/FoodSearchResponse.js";
import { BrandedFoodItem } from "../../models/BrandedFoodItem.js";
import Pop from "@/utils/Pop.js";
import Dropdown from "../Dropdown.vue";
import Checkbox from "../Checkbox.vue";
import UsdaFoodCard from "./UsdaFoodCard.vue";

const emit = defineEmits(['increase-by', 'extraButton'])

function handleIncreaseBy(item) {
  emit('increase-by', item); // Re-emit the event upwards
}

const form = useForm({
  query: '',
  type: 'Branded',
  requireAllWords: true
});

const usdaResponse = reactive({
  /** @type {FoodSearchResponse} */
  foodSearchResponse: new FoodSearchResponse({
    totalHits: 0,
    currentPage: 0,
    totalPages: 0,
  }),
  /** @type {BrandedFoodItem[]} */
  foods: []
})

const foodSearchResponse = computed(() => usdaResponse.foodSearchResponse)
const foods = computed(() => usdaResponse.foods)

const typeName = computed(() => {
  return {
    "SR Legacy": 'Legacy',
    Foundation: 'Foundation',
    Branded: 'Branded'
  }[form.type]
})

async function fetchFoodData(page = 1) {
  try {

    let query = form.query.replace(/"/g, '').trim();

    if (form.requireAllWords) {
      let newArray = query.split(' ').map(a => '+' + a);
      query = newArray.join(' ');
      console.log(query)
    }


    const response = await axios.get('/search-foodData', {
      params: {
        query: query,
        pageNumber: page,
        pageSize: 10,
        dataType: form.type
      },
    });

    const foodSearchResponse = new FoodSearchResponse(response.data)
    const foods = response.data.foods.map(f => new BrandedFoodItem(f))
    usdaResponse.foodSearchResponse = foodSearchResponse
    usdaResponse.foods = foods

  } catch (error) {
    console.error(error, '[Error fetching food data]')
  }
}


function handleExtraButton(item, action) {
  if (action == 'edit' || action == 'add') {
    emit('extraButton', item, action)
  } else {
    favoriteItem(item)
  }
}

async function favoriteItem(foodItem) {
  const data = {
    ...foodItem,
    calories: foodItem.calories
  };

  try {
    const confirmFavorite = await Pop.confirm(`add ${foodItem.description} to favorite foods? `)
    if (!confirmFavorite) {
      return
    }
    // Post the food item data to your backend
    const res = await axios.post(route('food.store'), data);

    // On success, reload only the relevant props to update the UI reactively
    router.reload({
      only: ['with_fdcId', 'without_fdcId'],  // Only reload the updated data
    });
    Pop.success(`${foodItem.description} added to favorites`)

  } catch (error) {
    console.error(error);  // Handle any error (optional)
  }
}

</script>

<template>
  <label for="" class="block font-bold hidden">Search for food</label>

  <div class="mb-3 mt-6">
    <form @submit.prevent="fetchFoodData(1)" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="flex justify-between items-center">
        <div class="flex-1">
          <TextInput id="query" type="text" class=" block w-full p-2 text-sm" v-model="form.query" required autofocus />
          <InputError class="mt-2" :message="form.errors.query" />
        </div>

        <div class="flex ">
          <PrimaryButton class=" w-full justify-center" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing">
            Search <i class="ps-3 mdi mdi-magnify"></i>
          </PrimaryButton>
        </div>
      </div>

      <div class="grid grid-cols-2 p-1">
        <div class=" flex justify-start">
          <Dropdown align="left" width="100">

            <template #trigger>
              <span class="flex rounded-md">
                <button type="button"
                  class="flex justify-between items-center h-10 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                  <p>
                    Type:
                  </p>
                  <span class="flex-1 text-center">
                    {{ typeName }}
                  </span>
                </button>
              </span>
            </template>

            <template #content>
              <div class="flex flex-col p-2">
                <button class="text-start p-1" :class="[form.type == 'Branded' ? 'border border-black/25 rounded' : '']"
                  type="button" @click="form.type = 'Branded'">Branded</button>
                <button class="text-start p-1"
                  :class="[form.type == 'Foundation' ? 'border border-black/25 rounded' : '']" type="button"
                  @click="form.type = 'Foundation'">Foundational</button>
                <button class="text-start p-1"
                  :class="[form.type == 'SR Legacy' ? 'border border-black/25 rounded' : '']" type="button"
                  @click="form.type = 'SR Legacy'">Legacy</button>
              </div>
            </template>

          </Dropdown>
        </div>

        <div class="flex justify-center items-center ">
          <Checkbox class="h-6 w-6" v-model:checked="form.requireAllWords" /><span class="ms-3 text-xs">Require All
            Words</span>
        </div>
      </div>


    </form>
  </div>

  <div v-if="foodSearchResponse" class="flex justify-between items-center mb-3">
    <button @click="fetchFoodData(foodSearchResponse.currentPage - 1)" :disabled="foodSearchResponse.currentPage <= 1"
      :class="foodSearchResponse.currentPage <= 1 ? 'text-black/25' : 'hover:bg-gray-600 bg-gray-500 text-white'"
      class="bg-gray-300 py-1 px-3 rounded">
      Previous
    </button>

    <p class="text-xs sm:text-base font-semibold text-black/50"> Hits: {{ foodSearchResponse.totalHits }}</p>
    <p class="text-xs sm:text-base font-semibold text-black/50"> Page: {{ foodSearchResponse.currentPage }} - {{
      foodSearchResponse.totalPages }} </p>

    <button @click="fetchFoodData(foodSearchResponse.currentPage + 1)"
      :disabled="foodSearchResponse.currentPage >= foodSearchResponse.totalPages"
      :class="foodSearchResponse.currentPage >= foodSearchResponse.totalPages ? 'text-black/25' : 'hover:bg-gray-600 bg-gray-500 text-white'"
      class="bg-gray-300  py-1 px-3 rounded">
      Next
    </button>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-2 text-center border-4 rounded-lg border-black/25">

    <div v-if="!foodSearchResponse.currentPage"
      class="break-inside-avoid relative flex flex-col justify-center w-full text-xl font-bold bg-gray-300 p-3 shadow h-40 rounded">
      Search for an item to begin counting calories!
    </div>
    <div v-if="foodSearchResponse.currentPage && foods.length == 0"
      class="break-inside-avoid relative flex flex-col justify-center w-full text-gray-300 text-xl font-bold bg-gray-800 p-3 shadow h-40 rounded">
      No results found
    </div>

    <UsdaFoodCard :food-items="foods" @increase-by="handleIncreaseBy" @extraButton="handleExtraButton" />

  </div>
</template>