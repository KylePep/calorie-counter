<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

interface FoodNutrient {
  value: number;
  nutrientName: string;
  unitName: string;
  percentDailyValue: string;
}

interface BrandedFoodItem {
  fdcId: number;
  description: string;
  brandName: string;
  brandOwner: string;
  servingSize: number;
  servingSizeUnit: string;
  foodCategory: string;
  labelNutrients: object;
  marketCountry: string;
  ingredients: string;
  foodNutrients: FoodNutrient[];
}

interface FoodSearchResponse {
  totalHits: number;
  currentPage: number;
  totalPages: number;
  foods: BrandedFoodItem[];
}

const props = defineProps({
  calorieCount: Number,
});

defineEmits(['increaseBy'])

const form = useForm({
  query: '',
});

const foodDataItems = ref<FoodSearchResponse | null>(null);



const fetchFoodData = async (page = 1) => {
  try {

    let query = form.query.replace(/"/g, '').trim();

    query = `"${query}"`;

    const response = await axios.get('/food-data', {
      params: {
        query: query,
        pageNumber: page,
        pageSize: 10,
      },
    });

    foodDataItems.value = response.data

  } catch (error) {
    console.error(error, '[Error fetching food data]')
  }
}

</script>

<template>
  <label for="" class="block font-bold hidden">Search for food</label>
  <div class="flex mb-3 mt-6">
    <form @submit.prevent="fetchFoodData(1)" class="flex items-center">
      <div>
        <TextInput id="query" type="text" class=" block w-full" v-model="form.query" required autofocus />
        <InputError class="mt-2" :message="form.errors.query" />
      </div>

      <div class="flex justify-end">
        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Search <i class="ps-3 mdi mdi-magnify"></i>
        </PrimaryButton>
      </div>
      <p class="px-3 text-sm">* get as close to the products name as possible</p>
    </form>
  </div>

  <div v-if="foodDataItems" class="flex justify-between items-center mb-3">
    <button @click="fetchFoodData(foodDataItems.currentPage - 1)" :disabled="foodDataItems.currentPage <= 1"
      :class="foodDataItems.currentPage <= 1 ? 'text-black/25' : 'hover:bg-gray-200 text-black/75'"
      class="bg-gray-300 py-1 px-3 rounded">
      Previous
    </button>

    <p class="font-semibold text-black/50">Total Hits: {{ foodDataItems.totalHits }}</p>
    <p class="font-semibold text-black/50">Current Page: {{ foodDataItems.currentPage }}</p>
    <p class="font-semibold text-black/50">Total Pages: {{ foodDataItems.totalPages }}</p>

    <button @click="fetchFoodData(foodDataItems.currentPage + 1)"
      :disabled="foodDataItems.currentPage >= foodDataItems.totalPages"
      :class="foodDataItems.currentPage >= foodDataItems.totalPages ? 'text-black/25' : 'hover:bg-gray-200 text-black/75'"
      class="bg-gray-300  py-1 px-3 rounded">
      Next
    </button>
  </div>

  <div class="columns-2 sm:column-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">

    <div v-if="!foodDataItems"
      class="break-inside-avoid relative flex flex-col justify-center w-full text-xl font-bold hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow h-40">
      Search for an item to begin counting calories!
    </div>

    <div @click="$emit('increaseBy', Math.round(item.foodNutrients[3].value * (item.servingSize * .01)))"
      v-for="item in foodDataItems?.foods" :key="item.fdcId"
      class="break-inside-avoid relative flex flex-col justify-between w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow h-40">
      <!-- <img class="object-cover object-center h-full "
        src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt=""> -->
      <div class=" text-gray-800 font-bold drop-shadow-2xl"> {{
        item.description
      }}
        <p class="text-xs">
          ( {{ item.brandName }} by {{ item.brandOwner }} )
        </p>
      </div>
      <div class=" text-gray-800 font-bold text-7xl drop-shadow-2xl"> {{
        Math.round(item.foodNutrients[3].value * (item.servingSize * .01))
      }}
      </div>
    </div>
  </div>
</template>
