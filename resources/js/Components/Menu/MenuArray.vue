<script setup>
import { computed, ref } from "vue";
import CreateFood from "../FoodComponents/CreateFood.vue";
import Modal from "../Form/Modal.vue";
import MenuButton from "./MenuButton.vue";
import WeighInMenu from "./WeighInMenu.vue";
import MacroMenu from "./MacroMenu.vue";
import ConsumedMenu from "./ConsumedMenu.vue";
import FoodMenu from "./FoodMenu.vue";
import JournalMenu from "./JournalMenu.vue";
import CarrotMenu from "./CarrotMenu.vue";

const props = defineProps(["account", "weighIn", "carrots", "calorieDay", "foodItems"])

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

const menuOptions = computed(() => {
  return {
    weighIn: { name: `${props.weighIn ? props.weighIn.weight : 'Weigh In'}`, specialClass: 'lg:hidden' },
    macroList: { name: 'Macro List', specialClass: 'lg:col-span-2' },
    consumedList: { name: 'Consumed List', specialClass: 'lg:col-span-2' },
    foodList: { name: 'Your Foods', specialClass: 'lg:col-span-2' },
    journalEntry: { name: 'Journal Entry', specialClass: 'lg:hidden' },
    carrots: { name: 'Carrots', specialClass: 'lg:hidden' },
  }
});

function setActive(type) {
  modalContent.value = type;
  showModal.value = true;
}

const closeModal = () => {
  showModal.value = false;
  ActiveFoodItem.value = {};
}
</script>


<template>
  <section class="grid grid-cols-2 gap-1 lg:gap-3 w-full">

    <div v-for="option, index in menuOptions" :key="index" :class="option.specialClass">
      <MenuButton :class="option.specialClass" @click="setActive(index)"> {{ option.name }}
      </MenuButton>
    </div>

    <div class="col-span-2">
      <CreateFood />
    </div>

  </section>

  <Modal :show="showModal" @close="closeModal">
    <section v-if="modalContent == 'weighIn'">
      <WeighInMenu :weighIn="weighIn" />
    </section>
    <section v-if="modalContent == 'macroList'">
      <MacroMenu :account="account" :calorieDay="calorieDay" />
    </section>
    <section v-if="modalContent == 'consumedList'">
      <ConsumedMenu :dayItems="calorieDay.food_items" :calorieDay />
    </section>
    <section v-if="modalContent == 'foodList'">
      <FoodMenu size="xl" :list="props.foodItems" :calorieDay />
    </section>
    <section v-if="modalContent == 'journalEntry'">
      <JournalMenu :calorieDay="calorieDay" />
    </section>
    <section v-if="modalContent == 'carrots' && carrots">
      <CarrotMenu :carrots="carrots" />
    </section>
  </Modal>
</template>