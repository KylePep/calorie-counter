<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Pop from "@/utils/Pop.js";
import Modal from "../Form/Modal.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import MenuButton from "../Displays/MenuButton.vue";

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
});

const createFoodItem = () => {
  form.post(route('foodItem.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} created`);
      console.log('made it here');
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

  form.clearErrors();
  form.reset();
};

</script>

<template>
  <MenuButton class="" @click="confirmFoodDetails">Create Food</MenuButton>
  <!-- <PrimaryButton class="hidden lg:block shadow flex" @click="confirmFoodDetails">
    Create Food
  </PrimaryButton> -->

  <Modal :show="showCreateForm" @close="closeModal">

    <FoodDetailsForm :formData="form" @cancel="closeModal">

      <template #title>
        <h1 class="text-center text-xl font-bold">Create a Food</h1>
        <h2 class="text-center text-sm max-w-xs mx-auto">Complete this form, then use your new food to help track your
          calories!
        </h2>
      </template>

      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <PrimaryButton @click="createFoodItem">
        Create
      </PrimaryButton>
    </FoodDetailsForm>
  </Modal>
</template>
