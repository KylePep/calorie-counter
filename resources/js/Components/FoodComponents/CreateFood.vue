<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, nextTick, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import Pop from "@/utils/Pop.js";
import NumberInput from "@/Components/NumberInput.vue";
import Modal from "../Modal.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";

const showCreateForm = ref(false);

const confirmingFoodDetails = ref(false);
const nameInput = ref(null);

const confirmFoodDetails = () => {
  confirmingFoodDetails.value = true;

  // nextTick(() => nameInput.value.focus());
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
    { nutrientName: "carbs", value: 0, unitName: 'G' },
    { nutrientName: "sugar", value: 0, unitName: 'G' },
    { nutrientName: "fiber", value: 0, unitName: 'G' },
    { nutrientName: "calcium", value: 0, unitName: 'MG' },
    { nutrientName: "iron", value: 0, unitName: 'MG' },
    { nutrientName: "sodium", value: 0, unitName: 'MG' },
  ],
  ingredients: '',
});

const createFoodItem = () => {
  form.post(route('food.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} created`)
      console.log('made it here')
      form.reset()
      closeModal()
    },
    onError: (errors) => {
      console.log(errors); // Log validation errors
    },
  });
};

const closeModal = () => {
  confirmingFoodDetails.value = false;

  form.clearErrors();
  form.reset();
};

</script>

<template>
  <div>
    <PrimaryButton class="shadow" v-if="!showCreateForm" @click="confirmFoodDetails">
      Create New Food
    </PrimaryButton>

    <Modal :show="confirmingFoodDetails" @close="closeModal">

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
  </div>
</template>
