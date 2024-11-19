<script setup>
import { computed, watch } from "vue";
import Modal from "../Form/Modal.vue";
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../Form/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";

const emit = defineEmits(['closeModal']);

const props = defineProps(['foodItem']);

// const confirmingFoodDetailsEdit = computed(() => props.showModal);

const foodData = computed(() => props.foodItem);

watch(foodData, (newfoodData) => {
  setForm();
})


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
});

const setForm = () => {
  form.fdcId = props.foodItem?.fdcId || '',
    form.description = props.foodItem.description || '',
    form.brandName = props.foodItem.brandName || '',
    form.brandOwner = props.foodItem.brandOwner || '',
    form.servingSize = props.foodItem.servingSize || 1,
    form.servingSizeUnit = props.foodItem.servingSizeUnit || 'g',
    form.foodCategory = props.foodItem.foodCategory || '',
    form.calories = props.foodItem.calories || 0,
    form.ingredients = props.foodItem.ingredients || '',

    form.foodNutrients = props.foodItem.foodNutrients
}

watch(props.foodItem, setForm);


const closeModal = () => {
  emit('closeModal');

  form.clearErrors();
  form.reset();
};

async function deleteItem() {
  const confirmDelete = await Pop.confirm(`Delete ${form.description}?`)
  if (!confirmDelete) {
    return;
  }
  form.delete(route('foodItem.destroy', props.foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} deleted`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

async function updateItem() {
  form.put(route('foodItem.update', props.foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} updated`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

</script>


<template>
  <FoodDetailsForm :formData="form" @cancel="closeModal">
    <template #title>
      <h1 class="text-center text-xl font-bold">Updating {{ form.description }}</h1>
    </template>

    <SecondaryButton type="button" @click="closeModal">
      Cancel
    </SecondaryButton>
    <DangerButton type="button" @click="deleteItem">
      Delete
    </DangerButton>
    <PrimaryButton @click="updateItem">
      Update
    </PrimaryButton>
  </FoodDetailsForm>

</template>