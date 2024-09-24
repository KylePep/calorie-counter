<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

const props = defineProps({
  calorieCount: Number,
});

defineEmits(['increaseBy'])

const form = useForm({
  query: '',
});

const foodItems = [
  { calH: 'h-[10rem]', size: 100 },
  { calH: 'h-[20rem]', size: 200 },
  { calH: 'h-[40rem]', size: 400 },
  { calH: 'h-[10rem]', size: 100 },
  { calH: 'h-[50rem]', size: 500 },
  { calH: 'h-[20rem]', size: 200 },
  { calH: 'h-[10rem]', size: 100 },
  { calH: 'h-[10rem]', size: 100 },
]

let foodDataItems = ref({})

const fetchFoodData = async () => {
  try {
    const foodItems = await axios.get('/food-data', {
      params: {
        query: form.query,
      },
    });
    foodDataItems.value = foodItems.data;
  } catch (error) {
    console.error(error, '[Error fetching food data]')
  }
}

onMounted(() => {
  // fetchFoodData()
})

</script>

<template>

  <!-- {{ foodDataItems.foods[0] }} -->

  <p class="mt-6">Search?</p>
  <label for="" class="block font-bold">USDA</label>
  <div class="flex mb-3">
    <form @submit.prevent="fetchFoodData" class="flex items-center">
      <div>
        <TextInput id="query" type="text" class=" block w-full" v-model="form.query" required autofocus />
        <InputError class="mt-2" :message="form.errors.query" />
      </div>

      <div class="flex justify-end">
        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Search
        </PrimaryButton>
      </div>
    </form>
  </div>

  <div v-if="foodDataItems" class="space-y-4 grid grid-cols-2 gap-3">
    <div v-for="food in foodDataItems.foods" :key="food.fdcId" class="grid grid-cols-2 bg-gray-300 rounded text-sm">
      <div>
        <!-- <p>
          {{ food.fdcId }}
        </p> -->
        <p>
          {{ food.brandName }} by {{ food.brandOwner }}
        </p>
        <p>
          {{ food.description }}
        </p>
        <p>
          Serving Size:
          {{ food.servingSize }}

          {{ food.servingSizeUnit }}
        </p>
        <p>
          Food Category:
          {{ food.foodCategory }}
        </p>
        <p>
          Market Country:
          {{ food.marketCountry }}
        </p>
      </div>

      <ul class="">
        <li>Nutrients</li>
        <li class="my-2" v-for="foodItem in food.foodNutrients">
          <div v-if="foodItem.value != 0">
            {{ foodItem.nutrientName }}: {{ foodItem.value }} {{ foodItem.unitName }}
            <span v-if="foodItem.percentDailyValue"> - {{
              foodItem.percentDailyValue
            }}%</span>
          </div>
        </li>
      </ul>
    </div>
  </div>


  <div class="columns-2 sm:column-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">
    <div @click="$emit('increaseBy', item.size)" v-for="item, index in foodItems" :key="index" :class="item.calH"
      class="break-inside-avoid relative flex justify-center w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow">
      <img class="object-cover object-center h-full "
        src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt="">
      <div class="absolute inset-y-1/4 text-gray-800 font-bold text-7xl drop-shadow-2xl"> {{
        item.size
      }}
      </div>
    </div>
  </div>
</template>
