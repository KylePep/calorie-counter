<script setup>
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import ItemsDisplay from "@/Components/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);



const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const showEditForm = ref(false);
const ActiveFoodItem = ref({})

function setActive(foodItem) {
  showEditForm.value = true;
  ActiveFoodItem.value = foodItem;
  console.log('[ACTIVE FOOD]', ActiveFoodItem.value)
}
const closeModal = () => {
  showEditForm.value = false;
  ActiveFoodItem.value = {};
}

</script>


<template>

  <Head title="Dashboard">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Food</h2>
    </template>

    <div class="space-y-12 max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

      <section v-if="!props.account">
        <div class="font-bold text-2xl">
          Unlock more features by completing account setup!
        </div>
      </section>

      <section v-if="props.account">
        <CreateFood />
      </section>

      <section v-if="props.account">
        <ItemsDisplay size="lg" :list="without_fdcId" @item-Activated="setActive" />
      </section>

      <section v-if="props.account">
        <ItemsDisplay size="lg" :list="with_fdcId" @item-Activated="setActive" />
      </section>

      <section>
        <FoodList />
      </section>
      <FoodEditModal :showModal="showEditForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

    </div>

  </GlobalLayout>
</template>


<style lang="scss" scoped></style>