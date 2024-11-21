<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import Pop from "@/utils/Pop.js";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import Side from "@/Components/Displays/Side.vue";
import UsdaSearch from "@/Components/FoodComponents/UsdaSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import FoodMenuArray from "@/Components/Menu/FoodMenuArray.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);

const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const foodItems = computed(() => {
  return [...with_fdcId.value, ...without_fdcId.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

async function deleteFoodItem(foodItem) {
  const form = useForm(foodItem)

  const confirmDelete = await Pop.confirm(`Delete ${form.description}?`)
  if (!confirmDelete) {
    return
  }
  form.delete(route('foodItem.destroy', foodItem.id), {
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
    setActive(type, item)
  } else if (action == 'add') {
    return
  } else {
    deleteFoodItem(item)
  }
}

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

    <section v-if="props.account" class="block lg:hidden">
      <FoodMenuArray :foodItems />
    </section>

    <section>
      <UsdaSearch @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">Created Foods</h1>
      <ItemsDisplay size="lg" :list="without_fdcId" @item-Activated="setActive"
        @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
        <h1 class="text-xl font-bold">Your Foods</h1>
      </ItemsDisplay>
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">USDA Foods</h1>
      <ItemsDisplay size="lg" :list="with_fdcId" @item-Activated="setActive"
        @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
        <h1 class="text-xl font-bold">Favorite Foods</h1>
      </ItemsDisplay>
    </section>



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