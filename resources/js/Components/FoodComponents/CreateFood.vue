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
const cameraInput = ref(null);
const previewImageURL = ref(null);

const selectedFile = ref("");

const hasBackCamera = ref(false);

const triggerFileInput = () => {
  fileInput.value.click();
};

const triggerCameraInput = () => {
  cameraInput.value.click();
};

const handleFileChange = () => {
  const file = fileInput.value.files[0];
  form.photo = file;
  previewImageURL.value = URL.createObjectURL(file);
  selectedFile.value = file ? file.name : "";
};

const handleCameraCapture = () => {
  const file = cameraInput.value.files[0];
  form.photo = file;
  previewImageURL.value = URL.createObjectURL(file);
  selectedFile.value = file ? `captured: ${file.name}` : "";
}

const checkBackCamera = async () => {
  try {
    const devices = await navigator.mediaDevices.enumerateDevices();
    console.log(devices)
    hasBackCamera.value = devices.some(
      (device) => device.kind == "videoinput" && device.label.toLowerCase().includes("back")
    );
  } catch (error) {
    console.error("Error checking for back camera:", error);
  }
};

onMounted(() => {
  checkBackCamera();
});

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
        <InputLabel value="Add Image" for="photo" />
        <div class="flex space-x-1">
          <div v-if="hasBackCamera">
            <input ref="cameraInput" type="file" name="camera" id="camera" accept="image/*" capture="environment"
              class="hidden" @change="handleCameraCapture" />
            <PrimaryButton type="button" @click="triggerCameraInput"><i class="mdi mdi-camera"></i></PrimaryButton>
          </div>
          <div class="flex items-center">
            <input ref="fileInput" type="file" name="photo" id="photo" class="hidden" @change="handleFileChange">
            <PrimaryButton type="button" @click="triggerFileInput" class="text-nowrap">From File</PrimaryButton>
            <p v-if="selectedFile" class="pe-10 ms-2 text-sm truncate">
              {{ selectedFile }}
            </p>
          </div>
        </div>
      </template>

      <template #buttons>
        <SecondaryButton type="button" @click="closeModal">
          Cancel
        </SecondaryButton>
        <PrimaryButton @click="createFoodItem">
          Create
        </PrimaryButton>
      </template>
    </FoodDetailsForm>
  </Modal>
</template>
