<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import UsdaSearch from "@/Components/FoodComponents/UsdaSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import FoodMenuArray from "@/Components/Menu/FoodMenuArray.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);

const isSmallScreen = computed(() => { return window.innerWidth < 1024 });

const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const foodItems = computed(() => {
  return [...with_fdcId.value, ...without_fdcId.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

function setActive(type, foodItem) {
  console.log('[Modal Content Type]', type, foodItem);
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

  <Head title="Food">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout heroImage="/assets/blueprintSammich.jpeg" heroHeight="60">
    <template #header>
      Your Foods
    </template>


    <section v-if="!props.account">
      <div class="font-bold text-2xl">
        Unlock more features by completing account setup!
      </div>
    </section>

    <section v-if="props.account && isSmallScreen" class="">
      <FoodMenuArray :foodItems />
    </section>

    <section>
      <UsdaSearch @set-active="(item) => setActive('usda', item)" />
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">Created Foods</h1>
      <ItemsDisplay size="lg" :list="without_fdcId" @set-active="(item) => setActive('foodItem', item)">
        <h1 class=" text-xl font-bold">Your Foods</h1>
      </ItemsDisplay>
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">USDA Foods</h1>
      <ItemsDisplay size="lg" :list="with_fdcId" @set-active="(item) => setActive('foodItem', item)">
        <h1 class="text-xl font-bold">Favorite Foods</h1>
      </ItemsDisplay>
    </section>


    <template #leftSide></template>

    <template #rightSide>
      <div class="hidden lg:block" v-if="props.account">
        <FoodMenuArray :foodItems />
      </div>
    </template>

    <Modal :show="showModal" @close="closeModal">
      <FoodEditModal v-if="modalContent == 'foodItem'" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
      <UsdaFoodEditModal v-if="modalContent == 'usda'" @close-modal="closeModal" @useItem="updateCalorieDayFoodItem"
        :foodItem="ActiveFoodItem" />
    </Modal>

  </GlobalLayout>
</template>