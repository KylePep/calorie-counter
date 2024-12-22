<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import FoodItemSearch from "@/Components/FoodComponents/FoodItemSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import { ref } from "vue";

const searchPerformed = ref();
const breakfastFoods = [];
const lunchFoods = [];
const dinnerFoods = [];
const snackFoods = [];
const beverageFoods = [];


const props = defineProps(['account', 'foodItems']);

const showModal = ref(false);
const ActiveFoodItem = ref({});

function setActive(foodItem) {
  console.log(foodItem)
  showModal.value = true;
  if (foodItem) {
    ActiveFoodItem.value = foodItem;
  }
}

const scheduleRanges = ref()

function searchSchedule(ranges) {
  scheduleRanges.value = ranges
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

    <CalorieRatioSelector :account @setSearch="searchSchedule" />

    <div v-if="scheduleRanges" class="space-y-8">
      <FoodItemRatioResults :account mealType="breakfast" :foodItems="breakfastFoods"
        :percent="scheduleRanges.breakfast" bgColor="bg-accent-light/50" @setActive="setActive(item)">Breakfast
      </FoodItemRatioResults>
      <FoodItemRatioResults :account mealType="lunch" :foodItems="lunchFoods" :percent="scheduleRanges.lunch"
        bgColor="bg-accent/50" @setActive="setActive(item)">
        Lunch
      </FoodItemRatioResults>
      <FoodItemRatioResults :account mealType="dinner" :foodItems="dinnerFoods" :percent="scheduleRanges.dinner"
        bgColor="bg-accent-dark/50" @setActive="setActive(item)">Dinner
      </FoodItemRatioResults>
      <FoodItemRatioResults :account mealType="snack" :foodItems="snackFoods" :percent="scheduleRanges.other"
        bgColor="bg-special/50" @setActive="setActive(item)">
        Snack
      </FoodItemRatioResults>
      <FoodItemRatioResults :account mealType="beverage" :foodItems="beverageFoods" :percent="scheduleRanges.other"
        bgColor="bg-special/50" @setActive="setActive(item)">Beverage
      </FoodItemRatioResults>
    </div>

    <div>
      <p class="mb-2">
        Search the apps database for food that fits your needs, submitted by users like you!
      </p>
      <FoodItemSearch @setActive="setActive" />
    </div>
  </div>

  <Modal :show="showModal" @close="closeModal">
    <FoodCopyModal @close-modal="closeModal" :foodItem="ActiveFoodItem" />
  </Modal>
</template>


<style lang="scss" scoped></style>