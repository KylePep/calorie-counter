<script setup>
import SecondaryButton from "../Form/SecondaryButton.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../Form/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import InputLabel from "../Form/InputLabel.vue";
import { ref } from "vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

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
};

async function updateItem() {
  if (cropped.value == false && previewImageURL.value) {
    return
  }

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

// const fileInput = ref(null);
// const previewImageURL = ref(null);
// const selectedFile = ref("");
// const cropperRef = ref(null);
// const cropped = ref(false);

// const triggerFileInput = () => {
//   fileInput.value.click();
// };

// const handleFileChange = () => {
//   const file = fileInput.value.files[0];
//   if (file) {

//     const reader = new FileReader();
//     reader.onload = (e) => {
//       previewImageURL.value = e.target.result;
//     };
//     reader.readAsDataURL(file);
//     selectedFile.value = file.name;
//   }
// };

// function crop() {
//   cropped.value = true;
//   const { coordinates, canvas, } = cropperRef.value.getResult();
//   canvas.toBlob((blob) => {
//     // Do something with blob: upload to a server, download and etc.
//     previewImageURL.value = blob;
//   }, this.image.type);
//   form.photo = previewImageURL.value;
// };

</script>


<template>
  <FoodDetailsForm :formData="form" :previewImageURL="previewImageURL" @cancel="closeModal">
    <template #title>
      <h1 class="text-center text-xl font-bold">Updating {{ form.description }}
      </h1>
    </template>
    <!-- 
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

      <div v-if="previewImageURL" class="mt-4">
        <Cropper v-if="!cropped" ref="cropperRef" :src="previewImageURL" :auto-zoom="true"
          :stencil-size="{ width: 280, height: 140 }" :canvas="{ width: 280, height: 140 }" image-restriction="stencil"
          class="border" />
        <img v-else :src="previewImageURL" :alt="previewImageURL">
        <PrimaryButton v-if="!cropped" @click="crop" class="mt-4">Crop</PrimaryButton>
        <SecondaryButton v-else class="mt-4">Cropped</SecondaryButton>
      </div>

    </template> -->

    <template #buttons>
      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <DangerButton type="button" @click="deleteItem">
        Delete
      </DangerButton>
      <PrimaryButton v-if="!previewImageURL" @click="updateItem">
        Update
      </PrimaryButton>
      <div v-else>
        <PrimaryButton v-if="cropped" @click="updateItem">Update</PrimaryButton>
        <SecondaryButton v-else>Update</SecondaryButton>
      </div>
    </template>

  </FoodDetailsForm>

</template>