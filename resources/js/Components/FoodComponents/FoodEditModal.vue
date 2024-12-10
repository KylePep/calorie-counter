<script setup>
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../Form/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import InputLabel from "../Form/InputLabel.vue";
import { ref } from "vue";

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


const closeModal = () => {
  emit('closeModal');

  selectedFile.value = "";
  previewImageURL.value = null;

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
}

const fileInput = ref(null);

const previewImageURL = ref(null);

const selectedFile = ref("");

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileChange = () => {
  const file = fileInput.value.files[0];
  form.photo = file;
  previewImageURL.value = URL.createObjectURL(file);
  selectedFile.value = file ? file.name : "";
};

</script>


<template>
  <FoodDetailsForm :formData="form" :previewImageURL="previewImageURL" @cancel="closeModal">
    <template #title>
      <h1 class="text-center text-xl font-bold">Updating {{ form.description }}
      </h1>
    </template>

    <template #photoButton>
      <div v-if="!form.photo">

        <InputLabel value="Add Image" for="photo" />

        <div class="flex space-x-1">
          <div class="flex items-center">
            <input ref="fileInput" type="file" name="photo" id="photo" class="hidden" @change="handleFileChange">
            <PrimaryButton type="button" @click="triggerFileInput" class="text-nowrap">From File</PrimaryButton>
            <div v-if="selectedFile" class="w-full pe-10 ms-2 text-sm text-nowrap truncate">
              {{ selectedFile }}
            </div>
          </div>
        </div>
      </div>

    </template>

    <template #buttons>
      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <DangerButton type="button" @click="deleteItem">
        Delete
      </DangerButton>
      <PrimaryButton @click="updateItem">
        Update
      </PrimaryButton>
    </template>

  </FoodDetailsForm>

</template>