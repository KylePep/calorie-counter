<script setup>
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import ItemsDisplay from "@/Components/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import Pop from "@/utils/Pop.js";
import axios from "axios";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import Side from "@/Components/Side.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);


const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

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

async function deleteFoodItem(foodItem) {

  const form = useForm(foodItem)

  const confirmDelete = await Pop.confirm(`Delete ${form.description}?`)
  if (!confirmDelete) {
    return
  }
  form.delete(route('food.destroy', foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} deleted`)
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

function handleExtraButton(item, action, type) {
  if (action == 'edit') {
    setActive(item, type)
  } else if (action == 'add') {
    return
  } else {
    deleteFoodItem(item)
  }
}

</script>


<template>

  <Head title="Dashboard">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout>
    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Food</h2>
    </template>


    <section v-if="!props.account">
      <div class="font-bold text-2xl">
        Unlock more features by completing account setup!
      </div>
    </section>

    <section v-if="props.account" class="block 2xl:hidden">
      <CreateFood />
    </section>

    <section v-if="props.account">
      <ItemsDisplay size="lg" :list="without_fdcId" @item-Activated="setActive" @extra-button="handleExtraButton">
        <h1 class="text-xl font-bold">Your Foods</h1>
      </ItemsDisplay>
    </section>

    <section v-if="props.account">
      <ItemsDisplay size="lg" :list="with_fdcId" @item-Activated="setActive" @extra-button="handleExtraButton">
        <h1 class="text-xl font-bold">Favorite Foods</h1>
      </ItemsDisplay>
    </section>

    <section>
      <FoodList @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
    </section>

    <template #leftSide>
      <Side side="left" class="hidden lg:block" v-if="props.account">
        <CreateFood />
      </Side>
    </template>

    <FoodEditModal :showModal="showEditForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

    <UsdaFoodEditModal :showModal="showUsdaForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

  </GlobalLayout>
</template>


<style lang="scss" scoped></style>