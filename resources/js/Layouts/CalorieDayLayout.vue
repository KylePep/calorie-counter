<script setup>
import { computed, ref } from "vue";
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import UsdaSearch from "@/Components/FoodComponents/UsdaSearch.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import CalorieDisplay from '@/Components/FoodComponents/CalorieDisplay.vue'
import MacroDisplay from "@/Components/Displays/MacroDisplay.vue";
import Modal from "@/Components/Form/Modal.vue";
import MenuArray from "@/Components/Menu/MenuArray.vue";
import FoodCopyModal from "@/Components/FoodComponents/FoodCopyModal.vue";
import NoAccountCard from "@/Components/NoAccountCard.vue";

const props = defineProps(['account', 'calorieDay', 'foodItems', 'with_fdcId', 'without_fdcId', 'carrots', 'weighIn']);

const calorieDay = computed(() => props.calorieDay);

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

const goal = computed(() => props.calorieDay.goal);
const bmr = computed(() => props.calorieDay.bmr);
const calorieCount = computed(() => props.calorieDay.count ?? 0);

function setActive(type, foodItem) {
  modalContent.value = type;
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

  <section class="lg:sticky top-24 z-10">

    <div v-if="!props.account">
      <NoAccountCard />
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
      <MacroDisplay :account :calorieDay />
    </section>

    <section v-if="props.account" class="lg:hidden">
      <MenuArray :account :weighIn :carrots :calorieDay :foodItems />
    </section>


    <section v-if="props.account">
      <ConsumedList :foodItems="calorieDay.food_items" :calorieDay />
    </section>

    <section>
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">Foods</h1>
      <UsdaSearch @set-active="setActive" />

      <ItemsDisplay size="sm" :list="props.foodItems" :calorieDay @set-active="(item) => setActive('foodItem', item)">
        <h1>Your Foods</h1>
      </ItemsDisplay>
    </section>

  </section>

  <Modal :show="showModal" @close="closeModal">
    <FoodEditModal v-if="modalContent == 'foodItem'" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
    <FoodCopyModal v-if="modalContent == 'app'" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
    <UsdaFoodEditModal v-if="modalContent == 'usda'" @close-modal="closeModal" :foodItem="ActiveFoodItem" :calorieDay />
  </Modal>

</template>