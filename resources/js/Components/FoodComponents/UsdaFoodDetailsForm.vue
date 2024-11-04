<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import { computed, ref } from "vue";

const emit = defineEmits(['submitForm', 'cancel']);

const props = defineProps(['formData', 'loading']);

const form = computed(() => props.formData);

const showNutrients = ref(false);

const unitName = computed(() => {
  return {
    g: 'Gram(s)',
    u: 'Unit(s)',
    ml: 'MilliLiter(s)',
    MLT: 'MilliLiter(s)'
  }[props.formData.servingSizeUnit];
});

const loadingClasses = computed(() => {
  if (props.loading == false) {
    return '';
  } else {
    return 'animate-pulse bg-black/50 text-transparent';
  }
});

const modifier = computed(() => {
  return props.formData.portionModifier / 100;
});


</script>


<template>

  <form @submit.prevent="createFoodItem" action="" class="p-6 space-y-3">
    <slot name="title"></slot>

    <div class="flex  ">
      <div class="basis-3/5 me-3">
        <InputLabel for="description" value="Name or description"></InputLabel>
        <TextInput id="description" v-model="form.description" :class="loadingClasses" class="w-full  text-sm"
          ref="nameInput" required>
        </TextInput>
        <InputError :message="form.errors.description"></InputError>
      </div>
      <div class="basis-2/5">
        <InputLabel for="category" value="Category"></InputLabel>
        <TextInput id="category" v-model="form.foodCategory" :class="loadingClasses" class="w-full  text-sm" required>
        </TextInput>
        <InputError :message="form.errors.foodCategory"></InputError>

      </div>
    </div>

    <div class="flex  items-center">

      <div class="basis-3/5 me-3">
        <InputLabel for="calories" value="Amount of calories"></InputLabel>
        <div id="calories" :class="loadingClasses" class="rounded px-2 py-1 mt-2 text-sm">
          {{ Math.round(form.realCalories * modifier) }}
        </div>
      </div>

      <div class="flex basis-2/5">
        <div class="w-full relative">
          <div v-if="!form.servingSizeUnit">
            <InputLabel for="portion" value="Portion"></InputLabel>
            <div class="mt-2">
              <select v-model="form.portionModifier" id="portion" name="portion" :class="loadingClasses"
                class="block w-full rounded-md border-0 py-1.5  text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option value="100">100g</option>
                <option v-for="portion in form.foodPortions" :value=portion.gramWeight> {{ portion.amount }} {{
                  portion.modifier }} ({{ portion.gramWeight }}g)</option>
              </select>
            </div>
            <InputError :message="form.errors.portionModifier"></InputError>
          </div>

          <div v-else>
            <InputLabel for="servingSize" value="Serving Size"></InputLabel>
            <NumberInput id="servingSize" v-model="form.portionModifier" :class="loadingClasses" class="w-full  text-sm"
              required></NumberInput>
            <span class="absolute hidden sm:block right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 text-sm">{{
              unitName
            }}</span>
            <span class="absolute block sm:hidden right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 text-sm">{{
              formData.servingSizeUnit
            }}</span>
            <InputError :message="form.errors.servingSize"></InputError>
          </div>
        </div>

      </div>
    </div>

    <div>


      <div class="flex ">
        <div class="basis-1/2 me-3">
          <InputLabel for="brandName" value="Brand Name"></InputLabel>
          <TextInput id="brandName" v-model="form.brandName" :class="loadingClasses" class="w-full text-sm"></TextInput>
          <InputError :message="form.errors.brandName"></InputError>

        </div>
        <div class="basis-1/2">

          <InputLabel for="brandOwner" value="Brand Owner"></InputLabel>
          <TextInput id="brandOwner" v-model="form.brandOwner" :class="loadingClasses" class="w-full text-sm">
          </TextInput>
          <InputError :message="form.errors.brandOwner"></InputError>

        </div>
      </div>
    </div>




    <div>
      <InputLabel for="ingredients" value="Ingredients">
      </InputLabel>
      <textarea id="ingredients" v-model="form.ingredients" name="ingredients" :class="loadingClasses"
        class="w-full text-sm border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"
        style="resize: none;"></textarea>
      <InputError :message="form.errors.ingredients"></InputError>
    </div>

    <div>
      <button type="button" @click="showNutrients = !showNutrients" :class="loadingClasses"
        class="rounded-lg bg-gray-300 px-3 py-2">Nutrients
        <span :class="[!showNutrients ? 'mdi mdi-menu-down' : 'mdi mdi-menu-up']"></span> </button>
      <div v-if="showNutrients" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 text-center gap-2 mt-3">
        <div v-for="(nutrient, index) in form.foodNutrients" :key="index" class="relative">
          <InputLabel :for="nutrient.nutrientName" :value="nutrient.nutrientName"></InputLabel>
          <div class="relative">
            <NumberInput :id="nutrient.nutrientName" v-model="form.foodNutrients[index].value" :class="loadingClasses"
              class="w-full text-sm text-center">
            </NumberInput>
            <div
              class="absolute flex items-center justify-center pe-1 sm:pe-3 h-full right-0 top-0 text-black/50 text-sm sm:text-base font-bold">
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
