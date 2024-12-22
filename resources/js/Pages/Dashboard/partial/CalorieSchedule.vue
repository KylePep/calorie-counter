<script setup>
import CalorieRatioSelector from "@/Components/FoodComponents/CalorieRatioSelector.vue";
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import FoodItemRatioResults from "@/Components/FoodComponents/FoodItemRatioResults.vue";
import FoodItemSearch from "@/Components/FoodComponents/FoodItemSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const searchPerformed = ref();

const foods = ref({
  breakfast: [],
  lunch: [],
  dinner: [],
  snack: [],
  beverage: []
})


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

const scheduleRanges = ref({
  breakfast: 0,
  lunch: 0,
  dinner: 0,
  snack: 0,
  beverage: 0
});



function searchSchedule(ranges) {

  scheduleRanges.value = ranges;

  const form = useForm(() => {
    ranges;
  });

  form.get(route('foodItem.ratio'), {
    preserveScroll: true,
    onSuccess: () => {
      console.log('filteredFoodItems', form.data)
      foods.value = form.data.filteredFoodItems;
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

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

      <FoodItemRatioResults :account mealType="breakfast" :foodItems="foods.breakfast"
        :percent="scheduleRanges.breakfast" bgColor="bg-accent-light/50" @setActive="setActive(item)">Breakfast
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="lunch" :foodItems="foods.lunch" :percent="scheduleRanges.lunch"
        bgColor="bg-accent/50" @setActive="setActive(item)">
        Lunch
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="dinner" :foodItems="foods.dinner" :percent="scheduleRanges.dinner"
        bgColor="bg-accent-dark/50" @setActive="setActive(item)">Dinner
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="snack" :foodItems="foods.snack" :percent="scheduleRanges.snack"
        bgColor="bg-special/50" @setActive="setActive(item)">
        Snack
      </FoodItemRatioResults>

      <FoodItemRatioResults :account mealType="beverage" :foodItems="foods.beverage" :percent="scheduleRanges.beverage"
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