<script setup>
import { computed, nextTick, onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import SecondaryButton from "../SecondaryButton.vue";
import PrimaryButton from "../PrimaryButton.vue";
import FoodDetailsForm from "./FoodDetailsForm.vue";
import DangerButton from "../DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import { UsdaFoodItem } from "@/models/UsdaFoodItem.js";

const emit = defineEmits(['closeModal']);

const props = defineProps(['showModal', 'foodItem']);

const confirmingFoodDetailsEdit = computed(() => props.showModal);

const foodData = computed(() => props.foodItem)

async function getUsdaFoodById() {
  try {

    let foodId = props.foodItem.fdcId;

    if (!props.foodItem.fdcId) return;

    const response = await axios.get(`/foodData/${foodId}`);


    const foodItem = new UsdaFoodItem(response.data)
    console.log(foodItem)

    setForm(foodItem);

  } catch (error) {
    console.error(error, '[Error fetching food data]')
  }
}

watch(foodData, (newfoodData) => {

  getUsdaFoodById();

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

const setForm = (foodItem) => {
  form.fdcId = foodItem?.fdcId || '',
    form.description = foodItem.description || '',
    form.brandName = foodItem.brandName || '',
    form.brandOwner = foodItem.brandOwner || '',
    form.servingSize = foodItem.servingSize || 1,
    form.servingSizeUnit = foodItem.servingSizeUnit || 'g',
    form.foodCategory = foodItem.foodCategory || '',
    form.calories = foodItem.calories || 0,
    form.ingredients = foodItem.ingredients || '',

    form.foodNutrients = foodItem.foodNutrients
}

watch(props.foodItem, setForm)


const closeModal = () => {
  emit('closeModal');

  form.clearErrors();
  form.reset();
};

async function updateItem() {
  const confirmUpdate = await Pop.confirm(`Update ${form.description}? `)
  if (!confirmUpdate) {
    return
  }
  form.put(route('food.update', props.foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} updated`)
      form.reset()
      closeModal()
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

</script>


<template>
  <Modal :show="confirmingFoodDetailsEdit" @close="closeModal">
    <FoodDetailsForm :formData="form" @cancel="closeModal">
      <template #title>
        <h1 class="text-center text-xl font-bold">Edit {{ form.description }} before using or saving?</h1>
      </template>

      <SecondaryButton type="button" @click="closeModal">
        Cancel
      </SecondaryButton>
      <PrimaryButton @click="updateItem">
        Use
      </PrimaryButton>
      <PrimaryButton @click="updateItem">
        Save
      </PrimaryButton>
    </FoodDetailsForm>

  </Modal>


</template>


<style lang="scss" scoped></style>