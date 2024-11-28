<script setup>
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../Form/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";

const emit = defineEmits(['closeModal']);

const props = defineProps(['foodItem']);

const form = useForm({
  fdcId: '',
  description: '',
  brandName: '',
  brandOwner: '',
  servingSize: 1,
  servingSizeUnit: 'g',
  foodCategory: '',
  calories: 0,
  foodNutrients: [],
  ingredients: '',
  photo: '',
  creator_id: ''
});

function setForm() {
  form.fdcId = props.foodItem?.fdcId || '',
    form.description = props.foodItem.description || '',
    form.brandName = props.foodItem.brandName || '',
    form.brandOwner = props.foodItem.brandOwner || '',
    form.servingSize = props.foodItem.servingSize || 1,
    form.servingSizeUnit = props.foodItem.servingSizeUnit || 'g',
    form.foodCategory = props.foodItem.foodCategory || '',
    form.calories = props.foodItem.calories || 0,
    form.ingredients = props.foodItem.ingredients || '',

    form.foodNutrients = props.foodItem.foodNutrients,
    form.photo = props.foodItem.photo,
    form.creator_id = props.foodItem.creator_id
}
setForm();


const closeModal = () => {
  emit('closeModal');

  form.clearErrors();
  form.reset();
};

const copyFoodItem = () => {
  form.post(route('foodItem.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} copied`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

</script>


<template>
  <FoodDetailsForm :formData="form" @cancel="closeModal">
    <template #title>
      <h1 class="text-center text-xl font-bold">Copy {{ form.description }}?
      </h1>
      <h2 class="text-center">By: {{ props.foodItem.user.name }}</h2>
    </template>

    <template #buttons>
      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <PrimaryButton @click="copyFoodItem">
        Copy
      </PrimaryButton>
    </template>
  </FoodDetailsForm>

</template>