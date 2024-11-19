<script setup>
import Pop from "@/utils/Pop.js";
import axios from "axios";
import { computed, ref } from "vue";
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import FoodList from "@/Components/FoodComponents/UsdaSearch.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import CalorieDisplay from '@/Components/FoodComponents/CalorieDisplay.vue'
import MacroDisplay from "@/Components/Displays/MacroDisplay.vue";
import Modal from "@/Components/Form/Modal.vue";
import MenuArray from "@/Components/Menu/MenuArray.vue";

const props = defineProps(['account', 'calorieDay', 'foodItems', 'with_fdcId', 'without_fdcId', 'carrots', 'weighIn']);

const calorieDay = ref(props.calorieDay);

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

const goal = computed(() => calorieDay.value?.goal);
const bmr = computed(() => calorieDay.value?.bmr);
const calorieCount = computed(() => calorieDay.value?.count ?? 0);

async function removeAndSubtractFoodItem(foodItem) {
  const data = {
    remove: true,
    goal: calorieDay.value.goal,
    count: foodItem.count,
    food_items: [{ description: foodItem.description, count: foodItem.count }]
  };
  try {
    const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
    calorieDay.value = res.data
    Pop.success(`removed ${food_items.description}`)
  } catch (error) {

  }
}

async function updateCalorieDayFoodItem(foodItem) {
  try {
    const data = {
      goal: calorieDay.value.goal,
      count: foodItem.count,
      food_items: [{ description: foodItem.description, count: foodItem.count, protein: foodItem.protein.value, carbohydrates: foodItem.carbohydrates.value, fats: foodItem.fats.value }]
    };
    const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
    calorieDay.value = res.data
    Pop.success(`+ ${data.count} Calories`)
  } catch (error) {

  }
}

function handleExtraButton(item, action, type) {
  if (action == 'edit') {
    setActive(type, item)
  } else if (action == 'add') {
    updateCalorieDayFoodItem(item)
  } else {
    return
  }
}

function setActive(type, foodItem) {
  console.log('[Modal Content Type]', type, foodItem);
  modalContent.value = type;
  showModal.value = true;
  // if (foodItem != undefined) { 
  ActiveFoodItem.value = foodItem;
  // }
}

const closeModal = () => {
  showModal.value = false;
  ActiveFoodItem.value = {};
}

</script>

<template>

  <section>
    <div v-if="!props.account" class="pb-3">
      Please complete setting up your account to begin tracking your progress or begin by
      <Link class="font-bold" :href="route('calculator')">
      calculating your goal!
      </Link>
    </div>

    <div v-else>
      <div
        class="grid grid-cols-3 xl:grid-cols-4 font-bold text-xs xl:text-base text-neutral-text text-center bg-main border border-light border-b-0 rounded-t px-1 sm:px-3 -mb-4 py-1 uppercase">
        <p class="col-span-3 xl:col-span-1">
          <slot />
        </p>
        <p>
          calories:
          {{ calorieCount }}
        </p>
        <p>
          Goal:
          {{ goal }}
        </p>
        <p>
          BMR:
          {{ bmr }}
        </p>
      </div>
    </div>
  </section>

  <CalorieDisplay v-if="props.account" :goal="goal" :calorieCount="calorieCount" :bmr="bmr" />

  <section class="space-y-4">

    <section v-if="props.account && props.account.trackMacros == true">
      <MacroDisplay :account="account" :calorieDay="calorieDay" />
    </section>

    <section v-if="props.account" class="lg:hidden">
      <MenuArray :account :weighIn :carrots :calorieDay :foodItems />
    </section>


    <section v-if="props.account && calorieDay.food_items.length">
      <ConsumedList :dayItems="calorieDay.food_items" @remove-food-item="removeAndSubtractFoodItem" />
    </section>

    <section>
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">Foods</h1>
      <FoodList @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
      <ItemsDisplay size="sm" :list="props.foodItems" @item-Activated="updateCalorieDayFoodItem"
        @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
        <h1>Your Foods</h1>
      </ItemsDisplay>
    </section>

  </section>

  <Modal :show="showModal" @close="closeModal">
    <FoodEditModal v-if="modalContent == 'foodItem'" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
    <UsdaFoodEditModal v-if="modalContent == 'usda'" @close-modal="closeModal" @useItem="updateCalorieDayFoodItem"
      :foodItem="ActiveFoodItem" />
  </Modal>

</template>