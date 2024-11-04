<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import { computed, ref } from "vue";

const emit = defineEmits(['submitForm', 'cancel']);

const props = defineProps(['formData']);

const form = computed(() => props.formData);

const showNutrients = ref(false);

const unitName = computed(() => {
  return {
    g: 'Gram(s)',
    u: 'Unit(s)',
    ml: 'MilliLiter(s)',
    MLT: 'MilliLiter(s)'
  }[props.formData.servingSizeUnit];
})


</script>


<template>

  <form @submit.prevent="createFoodItem" action="" class="p-6 space-y-3">
    <slot name="title"></slot>


    <div class="flex">
      <div class="basis-3/5 me-3">
        <InputLabel for="description" value="Name or description"></InputLabel>
        <TextInput id="description" v-model="form.description" class="w-full" ref="nameInput" required></TextInput>
        <InputError :message="form.errors.description"></InputError>
      </div>
      <div class="basis-2/5">
        <InputLabel for="category" value="Category"></InputLabel>
        <TextInput id="category" v-model="form.foodCategory" class="w-full" required></TextInput>
        <InputError :message="form.errors.foodCategory"></InputError>

      </div>
    </div>

    <div class="flex flex-col sm:flex-row  sm:items-center space-y-2 sm:space-y-0">

      <div class="sm:basis-3/5 me-3">
        <InputLabel for="calories" value="Amount of calories"></InputLabel>
        <NumberInput id="calories" v-model="form.calories" class="w-full" required></NumberInput>
        <InputError :message="form.errors.calories"></InputError>
      </div>

      <div class="flex sm:basis-2/5">

        <div class="w-full relative">
          <InputLabel for="servingSize" value="Serving Size"></InputLabel>
          <NumberInput id="servingSize" v-model="form.servingSize" class="w-full" required></NumberInput>
          <span class="absolute right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 text-xs">{{ unitName
            }}</span>
          <InputError :message="form.errors.servingSize"></InputError>
        </div>

        <div class="flex flex-col justify-between ms-2">
          <InputLabel for="servingSizeUnit" value="Unit"></InputLabel>
          <div class="flex font-bold">
            <button id="g" type="button" @click="form.servingSizeUnit = 'g'"
              class="rounded-l-lg px-3 py-2 border-r border-white"
              :class="[form.servingSizeUnit == 'g' ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">g</button>
            <button id="u" type="button" @click="form.servingSizeUnit = 'u'" class="border-r border-white px-3 py-2  "
              :class="[form.servingSizeUnit == 'u' ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">u</button>
            <button id="ml" type="button" @click="form.servingSizeUnit = 'ml'" class=" rounded-r-lg px-3 py-2"
              :class="[(form.servingSizeUnit == 'ml' || form.servingSizeUnit == 'MLT') ? 'bg-gray-500 text-white' : 'bg-gray-300 hover:bg-gray-400 ']">ml</button>
          </div>
        </div>
      </div>

    </div>

    <div>


      <div class="flex ">
        <div class="basis-1/2 me-3">
          <InputLabel for="brandName" value="Brand Name"></InputLabel>
          <TextInput id="brandName" v-model="form.brandName" class="w-full"></TextInput>
          <InputError :message="form.errors.description"></InputError>

        </div>
        <div class="basis-1/2">

          <InputLabel for="brandOwner" value="Brand Owner"></InputLabel>
          <TextInput id="brandOwner" v-model="form.brandOwner" class="w-full"></TextInput>
          <InputError :message="form.errors.brandOwner"></InputError>

        </div>
      </div>
    </div>




    <div>
      <InputLabel for="ingredients" value="Ingredients">
      </InputLabel>
      <textarea id="ingredients" v-model="form.ingredients" name="ingredients"
        class="w-full border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"
        style="resize: none;"></textarea>
      <InputError :message="form.errors.ingredients"></InputError>
    </div>

    <div>
      <button type="button" @click="showNutrients = !showNutrients" class="rounded-lg bg-gray-300 px-3 py-2">Nutrients
        <span :class="[!showNutrients ? 'mdi mdi-menu-down' : 'mdi mdi-menu-up']"></span> </button>
      <div v-if="showNutrients" class="grid grid-cols-3 text-center gap-2 mt-3">
        <div v-for="(nutrient, index) in form.foodNutrients" :key="index">
          <InputLabel :for="nutrient.nutrientName" :value="nutrient.nutrientName"></InputLabel>
          <div class="relative">
            <NumberInput :id="nutrient.nutrientName" v-model="form.foodNutrients[index].value"
              class="w-full text-center">
            </NumberInput>
            <div
              class="absolute flex items-center justify-center pe-1 sm:pe-3 h-full right-0 top-0 text-black/50 text-xs sm:text-base font-bold">
              {{
                nutrient.unitName }}
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="flex justify-end gap-4">
      <slot />
    </div>

  </form>
</template>
