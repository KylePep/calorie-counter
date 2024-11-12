<script setup>
import { computed, ref, watch } from "vue";
import Modal from "../Form/Modal.vue";
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import { UsdaFoodItem } from "@/models/UsdaFoodItem.js";
import UsdaFoodDetailsForm from "./UsdaFoodDetailsForm.vue";

const emit = defineEmits(['closeModal', 'useItem']);

const props = defineProps(['showModal', 'foodItem']);

const page = usePage();
const isDashboard = page.url.includes('dashboard');

const loading = ref(false);

const confirmingFoodDetailsEdit = computed(() => props.showModal);

const foodData = computed(() => props.foodItem);

async function getUsdaFoodById() {
  loading.value = true;
  try {

    let foodId = props.foodItem.fdcId;

    if (!props.foodItem.fdcId) {
      loading.value = false;
      return;
    }

    const response = await axios.get(`/foodUsda/${foodId}`);


    const foodItem = new UsdaFoodItem(response.data);

    setForm(foodItem);
    loading.value = false;

  } catch (error) {
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}

watch(foodData, (newfoodData) => {

  getUsdaFoodById();

})


const form = useForm({
  fdcId: 0,
  gtinUpc: 0,
  ndbNumber: 0,
  description: '',
  calories: 0,
  realCalories: 0,
  dataType: '',
  foodClass: '',
  brandOwner: '',
  brandName: '',
  foodPortions: [],
  householdServingFullText: '',
  servingSize: 1,
  servingSizeUnit: '',
  foodCategory: '',
  labelNutrients: '',
  ingredients: '',
  foodNutrients: [
    { nutrientName: "protein", value: 0, unitName: 'G' },
    { nutrientName: "carbs", value: 0, unitName: 'G' },
    { nutrientName: "sugar", value: 0, unitName: 'G' },
    { nutrientName: "fiber", value: 0, unitName: 'G' },
    { nutrientName: "calcium", value: 0, unitName: 'MG' },
    { nutrientName: "iron", value: 0, unitName: 'MG' },
    { nutrientName: "sodium", value: 0, unitName: 'MG' },
  ],
});

const setForm = (foodItem) => {
  form.fdcId = foodItem.fdcId || 0,
    form.gtinUpc = foodItem.gtinUpc || 0,
    form.ndbNumber = foodItem.ndbNumber || 0,
    form.calories = 0,
    form.realCalories = foodItem.foodNutrients.find((fn) => fn.nutrientName == 'Energy').value || 0,
    form.description = foodItem.description,
    form.dataType = foodItem.dataType,
    form.foodClass = foodItem.foodClass,
    form.brandName = foodItem.brandName || 'N/A',
    form.brandOwner = foodItem.brandOwner || 'N/A',
    form.foodPortions = foodItem.foodPortions,
    form.portionModifier = foodItem.servingSize ? foodItem.servingSize : 100,
    form.householdServingFullText = foodItem.householdServingFullText ?? '',
    form.servingSize = foodItem.servingSize || 1,
    form.servingSizeUnit = foodItem.servingSizeUnit || '',
    form.foodCategory = '',
    form.labelNutrients = foodItem.labelNutrients || 'N/A',
    form.ingredients = foodItem.ingredients || 'N/A',
    form.foodNutrients = foodItem.foodNutrients
}

watch(props.foodItem, setForm);


const closeModal = () => {
  emit('closeModal');

  form.clearErrors();
  form.reset();
  loading.value = false;
};

const realCalories = computed(() => {
  return Math.round(form.realCalories * (form.portionModifier / 100));
});

function useItem() {
  form.calories = realCalories.value;
  emit('useItem', form);
  emit('closeModal');
}

const createFoodItem = () => {

  form.calories = realCalories.value;
  if (!form.servingSizeUnit) {
    form.servingSize = 100;
    form.servingSizeUnit = 'g';
  }

  form.post(route('foodItem.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} created`);
      closeModal();
    },
    onError: (errors) => {
      console.log(errors); // Log validation errors
    },
  });
};

</script>


<template>
  <Modal :show="confirmingFoodDetailsEdit" @close="closeModal">

    <UsdaFoodDetailsForm :formData="form" @cancel="closeModal" :loading="loading">
      <template #title>
        <h1 v-if="!loading" class="text-center text-base font-bold text-gray-700">Edit <span
            class="text-xl text-black">{{
              form.description }}</span>?
        </h1>
        <h1 v-else class="text-center text-xl font-bold">Loading</h1>
      </template>

      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <PrimaryButton v-if="isDashboard" @click="useItem">
        Use
      </PrimaryButton>
      <PrimaryButton @click="createFoodItem">
        Save
      </PrimaryButton>
    </UsdaFoodDetailsForm>

  </Modal>


</template>