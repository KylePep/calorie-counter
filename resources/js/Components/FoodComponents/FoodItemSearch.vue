<script setup>
import InputError from "@/Components/Form/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, ref } from "vue";
import Modal from "../Form/Modal.vue";
import FoodCard from "./FoodCard.vue";
import NumberInput from "../Form/NumberInput.vue";
import Dropdown from "../Form/Dropdown.vue";

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
  count: 0,
  type: 'Breakfast',
});

const foodSearchResponse = ref({
  "totalHits": 10,
  "currentPage": 1,
  "totalPages": 1
});

const foodsList = ref([]);

const loading = ref(false);

const loadingClasses = computed(() => {
  if (loading.value == true) {
    return 'animate-pulse';
  } else return '';
})

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
    foodSearchResponse.value = {
      "totalHits": 10,
      "currentPage": 1,
      "totalPages": 1
    };
    foodsList.value = foods;

    showResults();

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}

function setActive(item) {
  emit('setActive', 'app', item);
  closeModal();
}

function buttonClasses(value) {
  return value
    ? 'bg-neutral text-light-text'
    : 'bg-gradient-to-br from-accent to-accent-light border border-dark rounded font-bold text-dark-text hover:from-dark hover:to-neutral focus:from-dark focus:to-neutral hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-accent-light/20';
}

</script>

<template>

  <div class="bg-neutral border-x border-dark rounded -mb-0.5 p-1.5">
    <form @submit.prevent="fetchUserFoodItems" class="grid grid-cols-9 gap-1 ">

      <div class="col-span-3 text-light-text text-base font-bold flex items-center w-full h-8">
        Search App
      </div>

      <div class="col-span-3 lg:col-span-2 flex items-center ">
        <Dropdown align="left" width="100" class="w-full">

          <template #trigger>
            <button type="button"
              class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-light-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">

              <p class="flex-1 flex items-center text-center">
                {{ form.type }}
              </p>
              <i class="mdi mdi-menu-down text-lg"></i>
            </button>
          </template>

          <template #content>
            <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs">
              <button class="text-start p-1" :class="[form.type == 'Breakfast' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Breakfast'">Breakfast</button>
              <button class="text-start p-1" :class="[form.type == 'Lunch' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Lunch'">Lunch</button>
              <button class="text-start p-1" :class="[form.type == 'Dinner' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Dinner'">Dinneral</button>
              <button class="text-start p-1" :class="[form.type == 'Snack' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Snack'">Snack</button>
              <button class="text-start p-1" :class="[form.type == 'Beverage' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.type = 'Beverage'">Beverage</button>
            </div>
          </template>

        </Dropdown>
      </div>

      <div class="col-span-3 relative flex items-center ">
        <NumberInput id="query" aria-label="Food query text" type="text" class="w-full h-8 rounded text-xs lg:text-sm"
          v-model="form.query" required placeholder="Calorie Count" />
        <InputError :message="form.errors.query" />
        <button aria-label="Search for food" id="search" class="absolute right-0">
          <i
            class="mdi mdi-magnify bg-gradient-to-l from-main via-main h-8 rounded text-accent hover:text-dark-text text-2xl lg:text-2xl ps-8 pe-2 duration-300"></i>
        </button>
      </div>

    </form>
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
      <div v-if="foodSearchResponse.currentPage && foodsList.length == 0"
        class="break-inside-avoid relative flex flex-col justify-center w-full text-light-text text-xl font-bold bg-dark p-3 border-2 border-light drop-shadow-lg min-h-24 rounded">
        No results found
      </div>

      <div v-for="foodItem in foodsList">
        <FoodCard :foodItem="foodItem" @set-active="setActive" />
      </div>

    </div>

  </Modal>

</template>