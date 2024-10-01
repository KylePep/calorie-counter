<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const showCreateForm = ref(false);

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
  ingredients: [],
});

const createFoodItem = () => {
  form.post(route('food.store'), {
    onSuccess: () => {
      Inertia.reload({
        only: ['with_fdcId', 'without_fdcId'],  // Only reload the relevant props
        preserveScroll: true,  // Optional: keeps the scroll position
      })
      console.log('made it here')
      form.reset()
    },
    onError: (errors) => {
      console.log(errors); // Log validation errors
    },
  });
};

</script>

<template>
  <PrimaryButton v-if="!showCreateForm" @click="showCreateForm = !showCreateForm">
    Create New Food
  </PrimaryButton>
  <form v-if="showCreateForm" @submit.prevent="createFoodItem" action="" class="grid grid-cols-3 gap-3">
    <div>
      <InputLabel value="Name"></InputLabel>
      <TextInput v-model="form.description"></TextInput>
    </div>
    <div>
      <InputLabel value="Brand Name"></InputLabel>
      <TextInput v-model="form.brandName"></TextInput>
    </div>
    <div>
      <InputLabel value="Brand Owner"></InputLabel>
      <TextInput v-model="form.brandOwner"></TextInput>
    </div>
    <div>
      <InputLabel value="Calories"></InputLabel>
      <TextInput v-model="form.calories"></TextInput>
    </div>
    <div>
      <InputLabel value="Serving Size"></InputLabel>
      <TextInput v-model="form.servingSize"></TextInput>
    </div>
    <div class="flex items-center space-x-12">
      <div class="flex space-x-4">
        <Checkbox v-model="form.servingSizeUnit" checked />
        <InputLabel value="G"></InputLabel>
      </div>
      <div class="flex space-x-4">
        <Checkbox v-model="form.servingSizeUnit" />
        <InputLabel value="L"></InputLabel>
      </div>
    </div>
    <div>
      <InputLabel value="Category"></InputLabel>
      <TextInput v-model="form.foodCategory"></TextInput>
    </div>
    <div>
      <InputLabel value="Nutrients"></InputLabel>
      <TextInput v-model="form.foodNutrients"></TextInput>
    </div>
    <div>
      <InputLabel value="Ingredients"></InputLabel>
      <TextInput v-model="form.ingredients"></TextInput>
    </div>

    <div class="flex justify-end col-span-3 gap-4">
      <PrimaryButton>
        Create
      </PrimaryButton>
      <SecondaryButton type="button" @click="showCreateForm = !showCreateForm">
        Cancel
      </SecondaryButton>
    </div>
  </form>
</template>
