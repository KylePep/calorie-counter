<script setup>
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import Modal from "@/Components/Form/Modal.vue";
import { ref } from "vue";

const props = defineProps(['account', 'foodRecommendations']);

const showModal = ref(false);
const ActiveFoodItem = ref({});

function setActive(foodItem) {
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
  <div class="text-neutral-text p-4 lg:p-8">

    <h1 class="text-lg lg:text-2xl font-bold mb-3 bg-light px-2 py-1 rounded">
      Food Recommendations
    </h1>
    <div class="space-y-8 my-8">

      <FoodItemRatioResults :account mealType="breakfast" :foodItems="foodRecommendations.breakfast"
        :percent="account.ratios.breakfast" bgColor="bg-accent-light/50" @setActive="setActive">Breakfast
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="lunch" :foodItems="foodRecommendations.lunch"
        :percent="account.ratios.lunch" bgColor="bg-accent/50" @setActive="setActive">
        Lunch
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="dinner" :foodItems="foodRecommendations.dinner"
        :percent="account.ratios.dinner" bgColor="bg-accent-dark/50" @setActive="setActive">Dinner
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="snack" :foodItems="foodRecommendations.snack"
        :percent="account.ratios.snack" bgColor="bg-special/50" @setActive="setActive">
        Snack
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="beverage" :foodItems="foodRecommendations.beverage"
        :percent="account.ratios.beverage" bgColor="bg-special/50" @setActive="setActive">Beverage
      </FoodItemRatioResults>
    </div>

    <Modal :show="showModal" @close="closeModal">
      <FoodCopyModal @close-modal="closeModal" :foodItem="ActiveFoodItem" />
    </Modal>
  </div>

</template>


<style lang="scss" scoped></style>