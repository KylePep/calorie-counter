<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import Pop from "@/utils/Pop.js";
import Modal from "../Form/Modal.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import MenuButton from "../Menu/MenuButton.vue";
import InputLabel from "../Form/InputLabel.vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

const showCreateForm = ref(false);

const confirmFoodDetails = () => {
  showCreateForm.value = true;
};

const form = useForm({
  fdcId: '',
  description: '',
  brandName: '',
  brandOwner: '',
  servingSize: 1,
  servingSizeUnit: 'g',
  foodCategory: '',
  calories: 0,
  foodNutrients: [
    { nutrientName: "protein", value: 0, unitName: 'G' },
    { nutrientName: "carbohydrates", value: 0, unitName: 'G' },
    { nutrientName: "fats", value: 0, unitName: 'G' },
    { nutrientName: "sugar", value: 0, unitName: 'G' },
    { nutrientName: "fiber", value: 0, unitName: 'G' },
    { nutrientName: "calcium", value: 0, unitName: 'MG' },
    { nutrientName: "iron", value: 0, unitName: 'MG' },
    { nutrientName: "sodium", value: 0, unitName: 'MG' },
  ],
  ingredients: '',
  photo: ''
});


const createFoodItem = () => {
  console.log(form)
  form.post(route('foodItem.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} created`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};


const closeModal = () => {
  showCreateForm.value = false;
  selectedFile.value = "";
  previewImageURL.value = null;

  form.clearErrors();
  form.reset();
};

const fileInput = ref(null);
const previewImageURL = ref(null);
const selectedFile = ref("");
const cropperRef = ref(null);
const cropped = ref(false);

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileChange = () => {
  const file = fileInput.value.files[0];
  if (file) {

    const reader = new FileReader();
    reader.onload = (e) => {
      previewImageURL.value = e.target.result;
    };
    reader.readAsDataURL(file);
    selectedFile.value = file.name;
  }
};

function crop() {
  cropped.value = true;
  const { coordinates, canvas, } = cropperRef.value.getResult();
  previewImageURL.value = canvas.toDataURL();
  form.photo = previewImageURL.value;
};

</script>

<template>
  <MenuButton class="" @click="confirmFoodDetails">Create Food</MenuButton>

  <Modal :show="showCreateForm" @close="closeModal">
    <FoodDetailsForm :formData="form" :previewImageURL="previewImageURL" @cancel="closeModal">

      <template #title>
        <h1 class="text-center text-xl font-bold">Create a Food</h1>
        <h2 class="text-center text-sm max-w-xs mx-auto">Complete this form, then use your new food to help track your
          calories!
        </h2>
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

        <div v-if="previewImageURL" class="mt-4">
          <Cropper v-if="!cropped" ref="cropperRef" :src="previewImageURL" :auto-zoom="true"
            :stencil-size="{ width: 280, height: 140 }" :canvas="{ width: 280, height: 140 }"
            image-restriction="stencil" class="border" />
          <img v-else :src="previewImageURL" :alt="previewImageURL">
          <PrimaryButton v-if="!cropped" @click="crop" class="mt-4">Crop</PrimaryButton>
          <SecondaryButton v-else class="mt-4">Cropped</SecondaryButton>
        </div>

      </template>

      <template #buttons>
        <SecondaryButton type="button" @click="closeModal">
          Cancel
        </SecondaryButton>
        <PrimaryButton v-if="!previewImageURL" @click="createFoodItem">
          Create
        </PrimaryButton>
        <div v-else>
          <PrimaryButton v-if="cropped" @click="createFoodItem">Create</PrimaryButton>
          <SecondaryButton v-else>Create</SecondaryButton>
        </div>
      </template>
    </FoodDetailsForm>
  </Modal>
</template>
