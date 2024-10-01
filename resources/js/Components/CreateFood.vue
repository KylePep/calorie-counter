<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import InputError from "./InputError.vue";

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

    <!-- 'fdcId' => ['nullable'],
            'description' => ['required'],
            'brandName' => ['nullable'],
            'brandOwner' => ['nullable'],
            'servingSize' => ['required'],
            'servingSizeUnit' => ['required'],
            'foodCategory' => ['required'],
            'calories' => ['required'],
            'foodNutrients' => ['nullable'], //array
            'ingredients' => ['nullable'], //array -->
    <div>
      <InputLabel value="Name"></InputLabel>
      <TextInput v-model="form.description" required></TextInput>
      <InputError :message="form.errors.description"></InputError>
    </div>
    <div>
      <InputLabel value="Brand Name"></InputLabel>
      <TextInput v-model="form.brandName"></TextInput>
      <InputError :message="form.errors.description"></InputError>

    </div>
    <div>
      <InputLabel value="Brand Owner"></InputLabel>
      <TextInput v-model="form.brandOwner"></TextInput>
      <InputError :message="form.errors.brandOwner"></InputError>

    </div>
    <div>
      <InputLabel value="Calories"></InputLabel>
      <TextInput v-model="form.calories" required></TextInput>
      <InputError :message="form.errors.calories"></InputError>

    </div>
    <div>
      <InputLabel value="Serving Size"></InputLabel>
      <TextInput v-model="form.servingSize" required></TextInput>
      <InputError :message="form.errors.servingSize"></InputError>

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
      <TextInput v-model="form.foodCategory" required></TextInput>
      <InputError :message="form.errors.foodCategory"></InputError>

    </div>
    <div>
      <InputLabel value="Nutrients"></InputLabel>
      <TextInput v-model="form.foodNutrients"></TextInput>
      <InputError :message="form.errors.foodNutrients"></InputError>

    </div>
    <div>
      <InputLabel value="Ingredients"></InputLabel>
      <TextInput v-model="form.ingredients"></TextInput>
      <InputError :message="form.errors.ingredients"></InputError>

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
