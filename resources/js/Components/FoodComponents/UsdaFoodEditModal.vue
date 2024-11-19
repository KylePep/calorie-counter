<script setup>
import { computed, ref, watch } from "vue";
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import { UsdaFoodItem } from "@/models/UsdaFoodItem.js";
import UsdaFoodDetailsForm from "./UsdaFoodDetailsForm.vue";

const props = defineProps(['foodItem']);

const emit = defineEmits(['closeModal', 'useItem']);

const page = usePage();
const isDashboard = page.url.includes('dashboard');

const loading = ref(false);

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
getUsdaFoodById();



const form = useForm({
  fdcId: 0,
  gtinUpc: 0,
  ndbNumber: 0,
  description: '',
  calories: 0,
  dataType: '',
  brandOwner: '',
  brandName: '',
  foodPortions: [],
  portionModifier: 0,
  servingSize: 1,
  servingSizeUnit: '',
  foodCategory: '',
  ingredients: '',
  foodNutrients: [],
});

const setForm = (foodItem) => {
  form.fdcId = foodItem.fdcId || 0,
    form.gtinUpc = foodItem.gtinUpc || 0,
    form.ndbNumber = foodItem.ndbNumber || 0,
    form.calories = foodItem.foodNutrients.find((fn) => fn.nutrientName == 'Energy').value || 0,
    form.description = foodItem.description,
    form.dataType = foodItem.dataType,
    form.brandName = foodItem.brandName || 'N/A',
    form.brandOwner = foodItem.brandOwner || 'N/A',
    form.foodPortions = foodItem.foodPortions,
    form.portionModifier = foodItem.servingSize ? foodItem.servingSize : 100,
    form.servingSize = foodItem.servingSize || 1,
    form.servingSizeUnit = foodItem.servingSizeUnit || '',
    form.foodCategory = '',
    form.ingredients = foodItem.ingredients || 'N/A',
    form.foodNutrients = foodItem.foodNutrients
}

const closeModal = () => {
  emit('closeModal');
  form.clearErrors();
  form.reset();
  loading.value = false;
};

function useItem() {
  form.transform((data) => ({
    ...data,
    calories: Math.round(data.calories * data.portionModifier / 100),
    foodNutrients: data.foodNutrients.forEach(n => {
      n.value = Math.round(n.value * data.portionModifier / 100)
    })
  }))
  emit('useItem', form);
  emit('closeModal');
};

function createFoodItem() {

  if (!form.servingSizeUnit) {
    form.servingSize = form.portionModifier;
    form.servingSizeUnit = 'g';
  }
  form.transform((data) => ({
    ...data,
    calories: Math.round(data.calories * data.portionModifier / 100),
    foodNutrients: data.foodNutrients.map(n => ({
      ...n,
      value: Math.round(n.value * data.portionModifier / 100)
    }))
  }))
    .post(route('foodItem.store'), {
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

  <UsdaFoodDetailsForm :formData="form" @cancel="closeModal" :loading="loading">
    <template #title>
      <h1 v-if="!loading" class="text-center text-base font-bold text-gray-700">Edit <span class="text-xl text-black">{{
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
    <PrimaryButton @click="createFoodItem()">
      Save
    </PrimaryButton>
  </UsdaFoodDetailsForm>

</template>