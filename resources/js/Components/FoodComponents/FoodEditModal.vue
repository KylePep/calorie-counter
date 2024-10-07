<script setup>
import { computed, nextTick, onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import SecondaryButton from "../SecondaryButton.vue";
import PrimaryButton from "../PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../DangerButton.vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(['closeModal']);

const props = defineProps(['showModal', 'foodItem']);

const confirmingFoodDetailsEdit = computed(() => props.showModal);

const foodData = computed(() => props.foodItem)

watch(foodData, (newfoodData) => {
  console.log(`foodItem is ${newfoodData.description}`);
  setForm();
})


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

const setForm = () => {
  form.fdcId = props.foodItem?.fdcId || '',
    form.description = props.foodItem.description || '',
    form.brandName = props.foodItem.brandName || '',
    form.brandOwner = props.foodItem.brandOwner || '',
    form.servingSize = props.foodItem.servingSize || 1,
    form.servingSizeUnit = props.foodItem.servingSizeUnit || 'g',
    form.foodCategory = props.foodItem.foodCategory || '',
    form.calories = props.foodItem.calories || 0,
    form.ingredients = props.foodItem.ingredients || '',

    form.foodNutrients = form.foodNutrients.map(nutrient => {
      const nutrientValue = props.foodItem[nutrient.nutrientName]?.value || 0;
      return {
        ...nutrient,
        value: nutrientValue
      };
    });
}

watch(props.foodItem, setForm)


const closeModal = () => {
  emit('closeModal');

  form.clearErrors();
  form.reset();
};

const deleteItem = () => {
  console.log('delete', form)
}

const updateItem = () => {
  console.log('update')
}

</script>


<template>
  <Modal :show="confirmingFoodDetailsEdit" @close="closeModal">

    <FoodDetailsForm :formData="form" @cancel="closeModal">
      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <DangerButton @click="deleteItem">
        Delete
      </DangerButton>
      <PrimaryButton @click="updateItem">
        Update
      </PrimaryButton>
    </FoodDetailsForm>

  </Modal>


</template>


<style lang="scss" scoped></style>