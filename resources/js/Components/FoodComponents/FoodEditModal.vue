<script setup>
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../Form/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import { ref } from "vue";

const emit = defineEmits(['closeModal']);

const props = defineProps(['foodItem']);

const imageState = ref(null);

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
  photo: ''
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
    form.photo = props.foodItem.photo;
}
setForm();

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
};

async function updateItem() {

  if (imageState == 'selected') return

  form.post(route('foodItem.update', props.foodItem.id), {
    preserveScroll: true,
    data: {
      _method: 'PUT',
    },
    onSuccess: () => {
      Pop.success(`${form.description} updated`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

const setImageState = (state) => {
  imageState.value = state;
}

const closeModal = () => {
  emit('closeModal');
  form.clearErrors();
  form.reset();
};

</script>


<template>
  <FoodDetailsForm :formData="form" @cancel="closeModal" @imageState="setImageState" :imageState="currentImageState">
    <template #title>
      <h1 class="text-center text-xl font-bold">Updating {{ form.description }}
      </h1>
    </template>

    <template #buttons>
      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <DangerButton type="button" @click="deleteItem">
        Delete
      </DangerButton>
      <PrimaryButton v-if="!imageState" @click="updateItem">
        Update
      </PrimaryButton>
      <div v-else>
        <PrimaryButton v-if="imageState == 'cropped'" @click="updateItem">Update</PrimaryButton>
        <SecondaryButton v-else>Update</SecondaryButton>
      </div>
    </template>

  </FoodDetailsForm>

</template>