<script setup>
import InputError from "@/Components/Form/InputError.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, reactive, ref } from "vue";
import { FoodSearchResponse } from "../../models/FoodSearchResponse.js";
import { BrandedFoodItem } from "../../models/BrandedFoodItem.js";
import Pop from "@/utils/Pop.js";
import Dropdown from "../Form/Dropdown.vue";
import Checkbox from "../Form/Checkbox.vue";
import UsdaFoodCard from "./UsdaFoodCard.vue";
import CollapsableFolder from "../Displays/CollapsableFolder.vue";

const emit = defineEmits(['increase-by', 'extraButton']);

function handleIncreaseBy(item) {
  emit('increase-by', item);
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

const foodSearchResponse = computed(() => usdaResponse.foodSearchResponse);
const foods = computed(() => usdaResponse.foods);

const loading = ref(false);

const loadingClasses = computed(() => {
  if (loading.value == true) {
    return 'animate-pulse';
  } else return '';
})

const typeName = computed(() => {
  return {
    "SR Legacy": 'Legacy',
    Foundation: 'Foundation',
    Branded: 'Branded'
  }[form.type]
})

async function fetchFoodData(page = 1) {
  try {
    loading.value = true;
    let query = form.query.replace(/"/g, '').trim();

    if (form.requireAllWords) {
      let newArray = query.split(' ').map(a => '+' + a);
      query = newArray.join(' ');
      console.log(query)
    }

    const response = await axios.get('/search-foodUsda', {
      params: {
        query: query,
        pageNumber: page,
        pageSize: 9,
        dataType: form.type
      },
    });

    loading.value = false;

    const foodSearchResponse = new FoodSearchResponse(response.data);
    const foods = response.data.foods.map(f => new BrandedFoodItem(f));
    usdaResponse.foodSearchResponse = foodSearchResponse;
    usdaResponse.foods = foods;

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}


function handleExtraButton(item, action) {
  if (action == 'edit' || action == 'add') {
    emit('extraButton', item, action);
  } else {
    favoriteItem(item);
  }
}

async function favoriteItem(foodItem) {
  const data = {
    ...foodItem,
    calories: foodItem.calories
  };

  try {
    // Post the food item data to your backend
    const res = await axios.post(route('foodItem.store'), data);

    router.reload({
      only: ['with_fdcId', 'without_fdcId'],
    });
    Pop.success(`${foodItem.description} added to favorites`);

  } catch (error) {
    console.error(error);
  }
}

</script>

<template>
  <CollapsableFolder>

    <template #title>
      <h1>Search USDA Database</h1>
    </template>

    <template #content>


      <label for="" class="block font-bold hidden">Search for food</label>

      <div class="mb-3 -m-2">
        <form @submit.prevent="fetchFoodData(1)"
          class="grid grid-cols-10 gap-1 bg-neutral border-x border-dark text-xs p-1.5">

          <div class="col-span-3 sm:col-span-2 flex items-center ">
            <Dropdown align="left" width="100" class="w-full">

              <template #trigger>
                <button type="button"
                  class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-light-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">

                  <p class="flex-1 flex items-center text-center">
                    {{ typeName }}
                  </p>
                  <i class="mdi mdi-menu-down text-lg"></i>
                </button>
              </template>

              <template #content>
                <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs">
                  <button class="text-start p-1"
                    :class="[form.type == 'Branded' ? 'border border-black/25 rounded' : '']" type="button"
                    @click="form.type = 'Branded'">Branded</button>
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

          <div
            class="col-span-3 sm:col-span-3 flex justify-center items-center h-8 group hover:bg-dark rounded space-x-4 duration-300">
            <span
              class="block sm:hidden ps-1 text-[6px] leading-tight font-bold text-light-text group-hover:text-accent duration-300 uppercase">Require
              <br>
              All <br>
              Words</span>
            <span
              class="hidden sm:block text-xs font-bold text-light-text group-hover:text-accent duration-300 uppercase">Require
              All
              Words</span>
            <Checkbox class="h-6 w-6 group-hover:text-accent" v-model:checked="form.requireAllWords" />
          </div>



          <div class="col-span-4 sm:col-span-5 relative flex items-center ">
            <TextInput id="query" type="text" class="w-full h-8 rounded text-xs" v-model="form.query" required
              autofocus />
            <InputError :message="form.errors.query" />

            <button class="absolute right-0">
              <i
                class="mdi mdi-magnify bg-gradient-to-l from-main via-main h-8 rounded text-accent hover:text-dark-text text-2xl sm:text-2xl ps-8 pe-2 duration-300"></i>
            </button>
          </div>

        </form>
      </div>

      <div v-if="foodSearchResponse" class="flex justify-between items-center mb-3">
        <button @click="fetchFoodData(foodSearchResponse.currentPage - 1)"
          :disabled="foodSearchResponse.currentPage <= 1"
          :class="foodSearchResponse.currentPage <= 1 ? 'text-light-text bg-main border border-light' : 'hover:bg-dark bg-neutral text-light-text hover:text-main'"
          class=" py-1 px-3 rounded">
          Previous
        </button>

        <p :class="foodSearchResponse.totalHits ? 'text-dark-text' : 'text-neutral/75'"
          class="text-xs sm:text-base font-semibold ">
          Hits:
          {{
            foodSearchResponse.totalHits }}</p>
        <p :class="foodSearchResponse.currentPage ? 'text-dark-text' : 'text-neutral/75'"
          class="text-xs sm:text-base font-semibold ">
          Page: {{ foodSearchResponse.currentPage }} - {{
            foodSearchResponse.totalPages }} </p>

        <button @click="fetchFoodData(foodSearchResponse.currentPage + 1)"
          :disabled="foodSearchResponse.currentPage >= foodSearchResponse.totalPages"
          :class="foodSearchResponse.currentPage >= foodSearchResponse.totalPages ? 'text-light-text bg-main border border-light' : 'hover:bg-dark bg-neutral text-light-text hover:text-main'"
          class="  py-1 px-3 rounded">
          Next
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 min-[1600px]:grid-cols-3 gap-2 bg-light text-center ">

        <div v-if="!foodSearchResponse.currentPage" :class="loadingClasses"
          class="break-inside-avoid relative flex flex-col justify-center w-full text-xl font-bold bg-neutral text-light-text border-2 border-light p-3 drop-shadow-lg h-40 rounded">
          {{ !loading ? 'Search for an item to begin counting calories!' : 'Searching' }}
        </div>
        <div v-if="foodSearchResponse.currentPage && foods.length == 0"
          class="break-inside-avoid relative flex flex-col justify-center w-full text-light-text text-xl font-bold bg-dark p-3 border-2 border-light drop-shadow-lg h-40 rounded">
          No results found
        </div>

        <div v-for="foodItem in foods">
          <UsdaFoodCard :food-item="foodItem" @increase-by="handleIncreaseBy" @extraButton="handleExtraButton" />
        </div>

      </div>
    </template>

  </CollapsableFolder>
</template>