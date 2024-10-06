<script setup>
import Checkbox from "@/Components/Checkbox.vue";
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

const showCreateForm = ref(false);
const showNutrients = ref(false);

const confirmingFoodDetails = ref(false);
const nameInput = ref(null);

const confirmFoodDetails = () => {
  confirmingFoodDetails.value = true;

  nextTick(() => nameInput.value.focus());
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

const unitName = computed(() => {
  return {
    g: 'Gram(s)',
    u: 'Unit(s)',
    l: 'Liter(s)'
  }[form.servingSizeUnit]
})

const createFoodItem = () => {
  form.post(route('food.store'), {
    onSuccess: () => {
      Pop.success(`${form.description} created`)
      Inertia.reload({
        only: ['with_fdcId', 'without_fdcId'],
        preserveScroll: true,
      })
      console.log('made it here')
      form.reset()
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
  <PrimaryButton v-if="!showCreateForm" @click="confirmFoodDetails">
    Create New Food
  </PrimaryButton>

  <Modal :show="confirmingFoodDetails" @close="closeModal">
    <form @submit.prevent="createFoodItem" action="" class="p-6 space-y-3">

      <h1 class="text-center text-xl font-bold">Create a Food</h1>
      <h2 class="text-center text-sm max-w-xs mx-auto">Complete this form, then use your new food to help track your
        calories!
      </h2>

      <div class="flex  ">
        <div class="basis-3/5 me-3">
          <InputLabel value="Name or description"></InputLabel>
          <TextInput v-model="form.description" class="w-full" ref="nameInput" required></TextInput>
          <InputError :message="form.errors.description"></InputError>
        </div>
        <div class="basis-2/5">
          <InputLabel value="Category"></InputLabel>
          <TextInput v-model="form.foodCategory" class="w-full" required></TextInput>
          <InputError :message="form.errors.foodCategory"></InputError>

        </div>
      </div>

      <div class="flex  items-center">

        <div class="basis-3/5 me-3">
          <InputLabel value="Amount of calories"></InputLabel>
          <NumberInput v-model="form.calories" class="w-full" required></NumberInput>
          <InputError :message="form.errors.calories"></InputError>
        </div>

        <div class="flex basis-2/5">

          <div class="w-full relative">
            <InputLabel value="Serving Size"></InputLabel>
            <NumberInput v-model="form.servingSize" class="w-full" required></NumberInput>
            <span class="absolute right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 uppercase text-xs">{{ unitName
              }}</span>
            <InputError :message="form.errors.servingSize"></InputError>
          </div>

          <div class="flex flex-col justify-between ms-2">
            <InputLabel value="Unit"></InputLabel>
            <div class="flex font-bold">
              <button type="button" @click="form.servingSizeUnit = 'g'"
                class="rounded-l-lg px-3 py-2 border-r border-white"
                :class="[form.servingSizeUnit == 'g' ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">G</button>
              <button type="button" @click="form.servingSizeUnit = 'u'" class="border-r border-white px-3 py-2  "
                :class="[form.servingSizeUnit == 'u' ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">U</button>
              <button type="button" @click="form.servingSizeUnit = 'l'" class=" rounded-r-lg px-3 py-2  "
                :class="[form.servingSizeUnit == 'l' ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">L</button>
            </div>
          </div>
        </div>
      </div>

      <div>


        <div class="flex ">
          <div class="basis-1/2 me-3">
            <InputLabel value="Brand Name"></InputLabel>
            <TextInput v-model="form.brandName" class="w-full"></TextInput>
            <InputError :message="form.errors.description"></InputError>

          </div>
          <div class="basis-1/2">

            <InputLabel value="Brand Owner"></InputLabel>
            <TextInput v-model="form.brandOwner" class="w-full"></TextInput>
            <InputError :message="form.errors.brandOwner"></InputError>

          </div>
        </div>
      </div>




      <div class="">
        <InputLabel value="Ingredients">
        </InputLabel>
        <textarea v-model="form.ingredients" name="ingredients"
          class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          style="resize: none;"></textarea>
        <InputError :message="form.errors.ingredients"></InputError>
      </div>

      <div>
        <button type="button" @click="showNutrients = !showNutrients" class="rounded-lg bg-gray-300 px-3 py-2">Nutrients
          <span :class="[!showNutrients ? 'mdi mdi-menu-down' : 'mdi mdi-menu-up']"></span> </button>
        <div v-if="showNutrients" class="grid grid-cols-3 text-center gap-2 mt-3">
          <div v-for="(nutrient, index) in form.foodNutrients" :key="index" class="relative">
            <InputLabel :value="nutrient.nutrientName"></InputLabel>
            <NumberInput v-model="form.foodNutrients[index].value" class="w-full text-center"></NumberInput>
            <div class="absolute right-0 top-1/2 pe-3 text-black/50 font-bold">{{ nutrient.unitName }}</div>
          </div>
        </div>

        <!-- 
          <InputLabel value="Nutrients"></InputLabel>
        <TextInput v-model="form.foodNutrients"></TextInput>
        <InputError :message="form.errors.foodNutrients"></InputError> -->


      </div>

      <div class="flex justify-end col-span-3 gap-4">
        <SecondaryButton type="button" @click="closeModal">
          Cancel
        </SecondaryButton>
        <PrimaryButton>
          Create
        </PrimaryButton>
      </div>
    </form>
  </Modal>
</template>
