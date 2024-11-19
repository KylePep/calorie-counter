<script setup>
import { ref } from "vue";
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

function setActive(type) {
  console.log('[Modal Content Type]', type);
  modalContent.value = type;
  showModal.value = true;
}

const closeModal = () => {
  showModal.value = false;
  ActiveFoodItem.value = {};
}
</script>


<template>
  <section class="grid grid-cols-2 gap-2 w-full">
    <MenuButton v-if="!props.weighIn" @click="setActive('weighIn')" class="lg:hidden">Weigh In
    </MenuButton>
    <MenuButton v-else @click="setActive('weighIn')">{{ props.weighIn.weight }} lbs</MenuButton>
    <MenuButton @click="setActive('macroList')"> Macros List
    </MenuButton>
    <MenuButton @click="setActive('consumedList')">Consumed List
    </MenuButton>
    <MenuButton @click="setActive('foodList')"> Your Foods
    </MenuButton>
    <MenuButton @click="setActive('journalEntry')" class="lg:hidden">Journal Entry
    </MenuButton>
    <MenuButton @click="setActive('carrots')" class="lg:hidden">Carrots
    </MenuButton>
    <div class="col-span-2 lg:col-span-1">
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
      <ConsumedMenu :dayItems="calorieDay.food_items" />
    </section>
    <section v-if="modalContent == 'foodList'">
      <FoodMenu size="xl" :list="props.foodItems" />
    </section>
    <section v-if="modalContent == 'journalEntry'">
      <JournalMenu :calorieDay="calorieDay" />
    </section>
    <section v-if="modalContent == 'carrots'">
      <CarrotMenu :carrots="carrots" />
    </section>
  </Modal>
</template>