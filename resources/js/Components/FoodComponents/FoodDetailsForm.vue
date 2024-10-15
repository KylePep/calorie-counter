<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import NumberInput from "@/Components/NumberInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const emit = defineEmits(['submitForm', 'cancel']);

const props = defineProps(['formData'])

const form = computed(() => props.formData);

const showNutrients = ref(false);

const unitName = computed(() => {
  return {
    g: 'Gram(s)',
    u: 'Unit(s)',
    l: 'Liter(s)'
  }[props.formData.servingSizeUnit]
})


</script>


<template>

  <form @submit.prevent="createFoodItem" action="" class="p-6 space-y-3">
    <slot name="title"></slot>


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
          <span class="absolute right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 text-xs">{{ unitName
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


    </div>

    <div class="flex justify-end gap-4">
      <slot />

    </div>
  </form>
</template>
