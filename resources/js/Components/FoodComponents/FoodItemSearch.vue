<script setup>
import InputError from "@/Components/Form/InputError.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, reactive, ref } from "vue";
import { FoodSearchResponse } from "../../models/FoodSearchResponse.js";
import { BrandedFoodItem } from "../../models/BrandedFoodItem.js";
import Dropdown from "../Form/Dropdown.vue";
import Checkbox from "../Form/Checkbox.vue";
import UsdaFoodCard from "./UsdaFoodCard.vue";
import Modal from "../Form/Modal.vue";
import BarcodeScanner from "../BarcodeScanner.vue";
import InputLabel from "../Form/InputLabel.vue";

const emit = defineEmits(['setActive']);

const showModal = ref(false);

function showResults() {
  showModal.value = true;
}

const closeModal = () => {
  showModal.value = false;
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
    Branded: 'Branded',
    App: 'App'
  }[form.type]
})

async function fetchFoodData(page = 1) {
  try {
    loading.value = true;
    let query = form.query.replace(/"/g, '').trim();

    if (form.requireAllWords) {
      let newArray = query.split(' ').map(a => '+' + a);
      query = newArray.join(' ');
    }

    const response = await axios.get('/search-foodUsda', {
      params: {
        query: query,
        pageNumber: page,
        pageSize: 10,
        dataType: form.type
      },
    });

    loading.value = false;

    const foodSearchResponse = new FoodSearchResponse(response.data);
    const foods = response.data.foods.map(f => new BrandedFoodItem(f));
    usdaResponse.foodSearchResponse = foodSearchResponse;
    usdaResponse.foods = foods;

    showResults();

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}

async function fetchUserFoodItems(page = 1) {
  try {
    loading.value = true;

    const response = await axios.get('/foodItem/search', {
      params: {
        query: form.query,
        pageNumber: page,
        pageSize: 10,
      },
    });

    loading.value = false;

    const foods = response.data;
    usdaResponse.foodSearchResponse = {
      "totalHits": 10,
      "currentPage": 1,
      "totalPages": 1
    };
    usdaResponse.foods = foods;

    showResults();

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}


function parseFetchType() {
  if (form.type != 'App') {
    fetchFoodData(1)
  } else {
    fetchUserFoodItems(1)
  }
}

function setActive(item) {
  const type = form.type != 'App' ? 'usda' : 'app'
  emit('setActive', type, item);
  closeModal();
}

function buttonClasses(value) {
  return value
    ? 'bg-neutral text-light-text'
    : 'bg-gradient-to-br from-accent to-accent-light border border-dark rounded font-bold text-dark-text hover:from-dark hover:to-neutral focus:from-dark focus:to-neutral hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-accent-light/20';
}

</script>

<template>

  <div class="bg-neutral border-x border-dark rounded -mb-0.5 text-xs p-1.5">
    <form @submit.prevent="parseFetchType" class="grid grid-cols-10 gap-1 ">

      <div class="col-span-3 lg:col-span-2 flex items-center ">
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
              <button class="text-start p-1" :class="[form.type == 'Branded' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Branded'">Branded</button>
              <button class="text-start p-1" :class="[form.type == 'App' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'App'">App</button>
              <button class="text-start p-1"
                :class="[form.type == 'Foundation' ? 'border border-black/25 rounded' : '']" type="button"
                @click="form.type = 'Foundation'">Foundational</button>
              <button class="text-start p-1" :class="[form.type == 'SR Legacy' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'SR Legacy'">Legacy</button>
            </div>
          </template>

        </Dropdown>
      </div>

      <div v-if="form.type != 'App'"
        class="col-span-3 flex justify-center items-center h-8 group hover:bg-dark rounded space-x-4 duration-300">
        <span
          class="block lg:hidden ps-1 text-[6px] leading-tight font-bold text-light-text group-hover:text-accent duration-300 uppercase">Require
          <br>
          All <br>
          Words</span>
        <span
          class="hidden lg:block text-xs font-bold text-light-text group-hover:text-accent duration-300 uppercase">Require
          All
          Words</span>
        <Checkbox name="requireAllWords" aria-label="require all words" class="h-6 w-6 group-hover:text-accent"
          v-model:checked="form.requireAllWords" />
      </div>
      <div v-else class="col-span-3">

      </div>



      <div class="col-span-4 lg:col-span-5 relative flex items-center ">
        <TextInput id="query" aria-label="Food query text" type="text" class="w-full h-8 rounded text-xs lg:text-sm"
          v-model="form.query" required />
        <InputError :message="form.errors.query" />
        <button aria-label="Search for food" id="search" class="absolute right-0">
          <i
            class="mdi mdi-magnify bg-gradient-to-l from-main via-main h-8 rounded text-accent hover:text-dark-text text-2xl lg:text-2xl ps-8 pe-2 duration-300"></i>
        </button>
      </div>

    </form>

    <div class="lg:hidden mt-1.5">
      <BarcodeScanner @set-active="setActive" />
    </div>
  </div>

  <Modal :show="showModal" @close="closeModal">
    <div v-if="foodSearchResponse" class="flex justify-between items-center mb-3">
      <button @click="fetchFoodData(foodSearchResponse.currentPage - 1)" :disabled="foodSearchResponse.currentPage <= 1"
        :class="buttonClasses(foodSearchResponse.currentPage <= 1)" class=" py-1 px-3 rounded">
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
        :class="buttonClasses(foodSearchResponse.currentPage >= foodSearchResponse.totalPages)"
        class="  py-1 px-3 rounded">
        Next
      </button>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 min-[1600px]:grid-cols-3 gap-2 text-center ">

      <div v-if="!foodSearchResponse.currentPage" :class="loadingClasses"
        class="break-inside-avoid relative flex flex-col justify-center w-full text-sm sm:text-xl font-bold bg-neutral text-light-text border-2 border-light p-3 drop-shadow-lg min-h-24 rounded">
        {{ !loading ? 'Search for an item to begin counting calories!' : 'Searching' }}
      </div>
      <div v-if="foodSearchResponse.currentPage && foods.length == 0"
        class="break-inside-avoid relative flex flex-col justify-center w-full text-light-text text-xl font-bold bg-dark p-3 border-2 border-light drop-shadow-lg min-h-24 rounded">
        No results found
      </div>

      <div v-for="foodItem in foods">
        <UsdaFoodCard :food-item="foodItem" @set-active="setActive" />
      </div>

    </div>
  </Modal>
</template>