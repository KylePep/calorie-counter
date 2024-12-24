<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import FoodItemSearch from "@/Components/FoodComponents/FoodItemSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import axios from "axios";
import { ref } from "vue";

const props = defineProps(['account', 'foodItems', 'calorieDay']);

const foods = ref({
  breakfast: [],
  lunch: [],
  dinner: [],
  snack: [],
  beverage: []
})

const showModal = ref(false);
const ActiveFoodItem = ref({});

function setActive(foodItem) {
  console.log(foodItem)
  showModal.value = true;
  if (foodItem) {
    ActiveFoodItem.value = foodItem;
  }
}

const scheduleRanges = ref();


async function searchSchedule(ranges) {
  scheduleRanges.value = ranges
  console.log(scheduleRanges.value)
  try {
    const response = await axios.get('/foodItem/ratio', {
      params: {
        ranges: ranges
      },
    });
    console.log(response.data)
    foods.value = response.data;

  } catch (error) {
    console.error(error, '[Error fetching food data]');
  }
}

const closeModal = () => {
  showModal.value = false;
  ActiveFoodItem.value = {};
}

</script>


<template>
  <div class="text-neutral-text p-4 lg:p-8 space-y-8">

    <h1 class="text-2xl font-bold  mb-3">
      Calorie Schedule
    </h1>

    <CalorieRatioSelector :account :calorieDay @set-search="searchSchedule" />

    <div v-if="scheduleRanges" class="space-y-8">

      <FoodItemRatioResults :account mealType="breakfast" :foodItems="foods.breakfast"
        :percent="scheduleRanges.breakfast" bgColor="bg-accent-light/50" @setActive="setActive">Breakfast
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="lunch" :foodItems="foods.lunch" :percent="scheduleRanges.lunch"
        bgColor="bg-accent/50" @setActive="setActive">
        Lunch
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="dinner" :foodItems="foods.dinner" :percent="scheduleRanges.dinner"
        bgColor="bg-accent-dark/50" @setActive="setActive">Dinner
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="snack" :foodItems="foods.snack" :percent="scheduleRanges.snack"
        bgColor="bg-special/50" @setActive="setActive">
        Snack
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="beverage" :foodItems="foods.beverage" :percent="scheduleRanges.beverage"
        bgColor="bg-special/50" @setActive="setActive">Beverage
      </FoodItemRatioResults>
    </div>

  </div>

  <Modal :show="showModal" @close="closeModal">
    <FoodCopyModal @close-modal="closeModal" :foodItem="ActiveFoodItem" />
  </Modal>
</template>


<style lang="scss" scoped></style>