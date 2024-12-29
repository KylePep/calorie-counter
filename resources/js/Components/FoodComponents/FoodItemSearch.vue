<script setup>
import InputError from "@/Components/Form/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, ref } from "vue";
import Modal from "../Form/Modal.vue";
import NumberInput from "../Form/NumberInput.vue";
import Dropdown from "../Form/Dropdown.vue";
import FoodResultCard from "./FoodResultCard.vue";

const emit = defineEmits(['setActive']);

const showModal = ref(false);

function showResults() {
  showModal.value = true;
}

const closeModal = () => {
  showModal.value = false;
}

const form = useForm({
  query: null,
  count: 0,
  category: null,
  macro: null,
});

const foodSearchResponse = ref({});

const foodsList = ref([]);

const loading = ref(false);

const loadingClasses = computed(() => {
  if (loading.value == true) {
    return 'animate-pulse';
  } else return '';
})

async function fetchUserFoodItems() {
  try {

    loading.value = true;

    const response = await axios.get('/foodItem/search', {
      params: {
        query: form.query,
        count: form.count,
        category: form.category,
        macro: form.macro
      },
    });

    console.log('RESPONSE', response.data, 'PARAMS', response.config.params)

    loading.value = false;

    const foods = response.data;

    foodSearchResponse.value = {
      totalHits: 0,
      currentPage: 1,
      totalPages: 1
    };

    foodsList.value = foods;

    showResults();

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}

function setActive(item) {
  const type = 'app'
  emit('setActive', type, item);
  closeModal();
}

const macroName = computed(() => {
  return {
    highProtein: 'High Protein',
    lowCarb: 'Low Carbs',
    lowFat: 'Low Fats',
    noMacro: 'No Macro'
  }[form.macro]
})
</script>

<template>

  <div class="bg-neutral rounded -mb-0.5 p-1.5">
    <form @submit.prevent="fetchUserFoodItems" class="grid grid-cols-10 gap-1 ">



      <div class="col-span-5 lg:col-span-3  flex items-center ">
        <Dropdown align="left" width="100" class="w-full">

          <template #trigger>
            <button type="button"
              class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-light-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">

              <p class=" flex-1 flex items-center">
                {{ form.category ? form.category : 'Any' }}
              </p>
              <i class="mdi mdi-menu-down text-lg"></i>
            </button>
          </template>

          <template #content>
            <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs space-y-2">
              <button class="text-start p-1" :class="[form.category == '' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.category = ''">any</button>
              <button class="text-start p-1"
                :class="[form.category == 'breakfast' ? 'border border-black/25 rounded' : '']" type="button"
                @click="form.category = 'breakfast'">breakfast</button>
              <button class="text-start p-1" :class="[form.category == 'lunch' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.category = 'lunch'">lunch</button>
              <button class="text-start p-1"
                :class="[form.category == 'dinner' ? 'border border-black/25 rounded' : '']" type="button"
                @click="form.category = 'dinner'">dinner</button>
              <button class="text-start p-1" :class="[form.category == 'snack' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.category = 'snack'">snack</button>
              <button class="text-start p-1"
                :class="[form.category == 'beverage' ? 'border border-black/25 rounded' : '']" type="button"
                @click="form.category = 'beverage'">beverage</button>
            </div>
          </template>

        </Dropdown>
      </div>

      <div class="col-span-5 lg:col-span-3 flex items-center ">
        <Dropdown align="left" width="100" class="w-full">

          <template #trigger>
            <button type="button"
              class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-light-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">

              <p class="flex-1 flex items-center">
                {{ form.macro ? macroName : 'No Macro' }}
              </p>
              <i class="mdi mdi-menu-down text-lg"></i>
            </button>
          </template>

          <template #content>
            <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs space-y-2">
              <button class="text-start p-1" :class="[form.macro == 'noMacro' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.macro = 'noMacro'">No Macro</button>
              <button class="text-start p-1"
                :class="[form.macro == 'highProtein' ? 'border border-black/25 rounded' : '']" type="button"
                @click="form.macro = 'highProtein'">High Protein</button>
              <button class="text-start p-1" :class="[form.macro == 'lowCarb' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.macro = 'lowCarb'">Low Carbs</button>
              <button class="text-start p-1" :class="[form.macro == 'lowFat' ? 'border border-black/25 rounded' : '']"
                type="button" @click="form.macro = 'lowFat'">Low Fats</button>
            </div>
          </template>

        </Dropdown>
      </div>

      <div class="col-span-10 lg:col-span-4 relative flex items-center ">
        <NumberInput id="count" aria-label="Food count value" class="w-full h-8 rounded font-bold text-xs lg:text-sm"
          v-model="form.count" placeholder="Calorie Quantity" />
        <InputError :message="form.errors.count" />
        <button aria-label="Search for food" id="search" class="absolute right-0">
          <i
            class="mdi mdi-magnify bg-gradient-to-l from-main via-main h-8 rounded text-accent hover:text-dark-text text-2xl lg:text-2xl ps-8 pe-2 duration-300"></i>
        </button>
      </div>

    </form>
  </div>

  <Modal :show="showModal" @close="closeModal">
    <div class="flex justify-center sm:text-lg font-bold py-2">
      Refined search results
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 text-center ">

      <div v-if="!foodSearchResponse.currentPage" :class="loadingClasses"
        class="break-inside-avoid relative flex flex-col justify-center w-full text-sm sm:text-xl font-bold bg-neutral text-light-text border-2 border-light p-3 drop-shadow-lg min-h-24 rounded">
        {{ !loading ? 'Search for an item to begin counting calories!' : 'Searching' }}
      </div>
      <div v-else-if="!foodsList.length"
        class="break-inside-avoid relative flex flex-col justify-center w-full text-light-text text-xl font-bold bg-dark p-3 border-2 border-light drop-shadow-lg min-h-24 rounded">
        No results found
      </div>

      <div v-for="foodItem in foodsList">
        <FoodResultCard :foodItem="foodItem" :is-search-result="true" @set-active="setActive" />
      </div>

    </div>

  </Modal>

</template>