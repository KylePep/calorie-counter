<script setup>
import Pop from "@/utils/Pop.js";
import axios from "axios";
import { computed, ref } from "vue";
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import CalorieDisplay from '@/Components/FoodComponents/CalorieDisplay.vue'
import MacroDisplay from "@/Components/Displays/MacroDisplay.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

const props = defineProps(['account', 'calorieDay', 'foodItems', 'with_fdcId', 'without_fdcId']);

const calorieDay = ref(props.calorieDay)

const goal = computed(() => calorieDay.value?.goal);
const bmr = computed(() => calorieDay.value?.bmr);

const calorieCount = computed(() => calorieDay.value?.count ?? 0);

const showEditForm = ref(false);
const showUsdaForm = ref(false);
const ActiveFoodItem = ref({})

function setActive(foodItem, type) {
  showEditForm.value = false;
  showUsdaForm.value = false;
  if (type == 'usda') {
    showUsdaForm.value = true;
  } else { showEditForm.value = true; }
  ActiveFoodItem.value = foodItem;
}
const closeModal = () => {
  showEditForm.value = false;
  showUsdaForm.value = false;
  ActiveFoodItem.value = {};
}

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
    setActive(item, type)
  } else if (action == 'add') {
    updateCalorieDayFoodItem(item)
  } else {
    return
  }
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

  <MacroDisplay v-if="props.account && props.account.trackMacros == true" :account="account" :calorieDay="calorieDay" />

  <section v-if="props.account && calorieDay.food_items.length">
    <ConsumedList :dayItems="calorieDay.food_items" @remove-food-item="removeAndSubtractFoodItem" />
  </section>

  <section v-if="props.account" class="block lg:hidden grid grid-cols-3 gap-1 ">
    <CreateFood />
    <PrimaryButton class=""> <span class="block sm:hidden mdi mdi-plus-thick"> WeighIn</span></PrimaryButton>
    <PrimaryButton class=""> <span class="block sm:hidden mdi mdi-plus-thick"> Journal</span></PrimaryButton>
    <PrimaryButton class="col-span-3 flex justify-center"><span class="block sm:hidden mdi mdi-menu-down">
        Carrot</span>
    </PrimaryButton>
  </section>

  <section v-if="props.account" class="block sm:hidden">
    <ItemsDisplay size="sm" :list="props.foodItems" @item-Activated="updateCalorieDayFoodItem"
      @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
      <h1>Your Foods</h1>
    </ItemsDisplay>
  </section>

  <section v-if="props.account" class="hidden sm:block">
    <ItemsDisplay size="sm" :list="props.without_fdcId" @item-Activated="updateCalorieDayFoodItem"
      @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
      <h1>Created Foods</h1>
    </ItemsDisplay>
  </section>

  <section v-if="props.account" class="hidden sm:block">
    <ItemsDisplay size="sm" :list="props.with_fdcId" @item-Activated="updateCalorieDayFoodItem"
      @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
      <h1>Saved Foods</h1>
    </ItemsDisplay>
  </section>

  <section>
    <FoodList @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
  </section>

  <FoodEditModal :showModal="showEditForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
  <UsdaFoodEditModal :showModal="showUsdaForm" @close-modal="closeModal" @useItem="updateCalorieDayFoodItem"
    :foodItem="ActiveFoodItem" />

</template>