<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import FoodItemSearch from "@/Components/FoodComponents/FoodItemSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import { ref } from "vue";

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

    <h2>
      Designate where you would like your calories to go.
    </h2>

    <div>
      Find Meals that work for you.
    </div>

    <div>
      Decide and set calorie ratios - Breakfast, Lunch, Dinner, Snack (Beverage)
    </div>

    <CalorieRatioSelector :account />

    <FoodItemRatioResults mealType="breakfast" :foodItems="breakfastFoods" bgColor="bg-accent-light/50"
      @setActive="setActive(item)">Breakfast
    </FoodItemRatioResults>
    <FoodItemRatioResults mealType="lunch" :foodItems="lunchFoods" bgColor="bg-accent/50" @setActive="setActive(item)">
      Lunch
    </FoodItemRatioResults>
    <FoodItemRatioResults mealType="dinner" :foodItems="dinnerFoods" bgColor="bg-accent-dark/50"
      @setActive="setActive(item)">Dinner
    </FoodItemRatioResults>
    <FoodItemRatioResults mealType="snack" :foodItems="snackFoods" bgColor="bg-special/50" @setActive="setActive(item)">
      Snack
    </FoodItemRatioResults>
    <FoodItemRatioResults mealType="beverage" :foodItems="beverageFoods" bgColor="bg-special/50"
      @setActive="setActive(item)">Beverage
    </FoodItemRatioResults>

    <div>
      Based on the ratios derived from your goal/bmr you can then search for food items from the apps ecosystem to help
      meet your goals.
    </div>
    <FoodItemSearch @setActive="setActive" />
  </div>

  <Modal :show="showModal" @close="closeModal">
    <FoodCopyModal @close-modal="closeModal" :foodItem="ActiveFoodItem" />
  </Modal>
</template>


<style lang="scss" scoped></style>