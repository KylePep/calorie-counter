<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Pop from "@/utils/Pop.js";
import Modal from "../Form/Modal.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import MenuButton from "../Menu/MenuButton.vue";

const showCreateForm = ref(false);
const imageState = ref(null);

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
  photo: '',
  qualities: ''
});

function evaluateQualities() {
  const calories = form.calories;

  const protein = form.foodNutrients.find(f => f.nutrientName == 'protein');
  const carbs = form.foodNutrients.find(f => f.nutrientName == 'carbohydrates');
  const fats = form.foodNutrients.find(f => f.nutrientName == 'fats');
  protein.title = "Protein"
  carbs.title = "Carb"
  fats.title = "Fat"

  const macros = [protein, carbs, fats];
  const percentages = [.10, .26, .30];

  let qualities = '';
  macros.forEach((m, index) => {
    if (m.value != 0) {
      if (calories * percentages[index] <= m.value) {
        qualities += ('high' + m.title + ',')
      } else {
        qualities += ('low' + m.title + ',')
      }
    }
  });

  return qualities
}


const createFoodItem = () => {

  if (imageState == 'selected') return

  const evaluatedQualities = evaluateQualities();

  form.transform((data) => ({
    ...data,
    qualities: evaluatedQualities
  })).post(route('foodItem.store'), {
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

const setImageState = (state) => {
  imageState.value = state;
}

const closeModal = () => {
  showCreateForm.value = false;
  imageState.value = null;
  form.clearErrors();
  form.reset();
};

</script>

<template>
  <MenuButton class="" @click="confirmFoodDetails">Create Food</MenuButton>

  <Modal :show="showCreateForm" @close="closeModal">
    <FoodDetailsForm :formData="form" @cancel="closeModal" @imageState="setImageState" :currentImageState="imageState">

      <template #title>
        <h1 class="text-center text-xl font-bold">Create a Food</h1>
        <h2 class="text-center text-sm max-w-xs mx-auto">Complete this form, then use your new food to help track your
          calories!
        </h2>
      </template>

      <template #buttons>
        <SecondaryButton type="button" @click="closeModal">
          Cancel
        </SecondaryButton>
        <PrimaryButton v-if="!imageState" @click="createFoodItem">
          Create
        </PrimaryButton>
        <div v-else>
          <PrimaryButton v-if="imageState == 'cropped'" @click="createFoodItem">Create</PrimaryButton>
          <SecondaryButton v-else>Create</SecondaryButton>
        </div>
      </template>

    </FoodDetailsForm>
  </Modal>
</template>
