<script setup>
import { ref } from "vue";
import CreateFood from "../FoodComponents/CreateFood.vue";
import Modal from "../Form/Modal.vue";
import MenuButton from "./MenuButton.vue";
import FoodMenu from "./FoodMenu.vue";

const props = defineProps(["foodItems"])

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
  <section class="grid grid-cols-1 gap-1 lg:gap-3 w-full">
    <MenuButton @click="setActive('foodList')"> Your Foods
    </MenuButton>
    <CreateFood />
  </section>

  <Modal :show="showModal" @close="closeModal">
    <section v-if="modalContent == 'foodList'">
      <FoodMenu size="xl" :list="props.foodItems" />
    </section>
  </Modal>
</template>