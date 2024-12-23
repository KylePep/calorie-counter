<script setup>
import { onMounted, ref } from "vue";
import SecondaryButton from "../Form/SecondaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";
import { UsdaFoodItem } from "@/models/UsdaFoodItem.js";
import UsdaFoodDetailsForm from "./UsdaFoodDetailsForm.vue";

const props = defineProps(['foodItem', 'calorieDay']);

const emit = defineEmits(['closeModal']);

const loading = ref(false);

const errorPage = ref(false);

// Receive either fdcId or upc

async function getUsdaFoodById() {
  loading.value = true;
  try {
    let foodId;

    if (!props.foodItem.fdcId && !props.foodItem.barcode) {
      loading.value = false;
      return;
    } else if (!props.foodItem.fdcId) {
      foodId = props.foodItem.barcode
    } else {
      foodId = props.foodItem.fdcId
    }


    if (foodId.length != 12) {
      const response = await axios.get(`/foodUsda/${foodId}`);
      const foodItem = new UsdaFoodItem(response.data);
      setForm(foodItem);
    } else {
      const response = await axios.get(`/foodUsda/${foodId}/upc`);
      const foodItem = new UsdaFoodItem(response.data);
      setForm(foodItem);
    }

    loading.value = false;

  } catch (error) {
    errorPage.value = true;
    loading.value = false;
    console.error(error, '[Error fetching food data]');
  }
}
onMounted(() => {
  getUsdaFoodById();
})




const form = useForm({
  fdcId: 0,
  gtinUpc: 0,
  ndbNumber: 0,
  description: '',
  calories: 0,
  dataType: '',
  brandOwner: '',
  brandName: '',
  foodPortions: [],
  portionModifier: 0,
  servingSize: 1,
  servingSizeUnit: '',
  foodCategory: '',
  ingredients: '',
  foodNutrients: [],
});

const setForm = (foodItem) => {
  form.fdcId = foodItem.fdcId || 0,
    form.gtinUpc = foodItem.gtinUpc || 0,
    form.ndbNumber = foodItem.ndbNumber || 0,
    form.calories = foodItem.foodNutrients.find((fn) => fn.nutrientName == 'Energy').value || 0,
    form.description = foodItem.description,
    form.dataType = foodItem.dataType,
    form.brandName = foodItem.brandName || 'N/A',
    form.brandOwner = foodItem.brandOwner || 'N/A',
    form.foodPortions = foodItem.foodPortions,
    form.portionModifier = foodItem.servingSize ? foodItem.servingSize : 100,
    form.servingSize = foodItem.servingSize || 1,
    form.servingSizeUnit = foodItem.servingSizeUnit || '',
    form.foodCategory = '',
    form.ingredients = foodItem.ingredients || 'N/A',
    form.foodNutrients = foodItem.foodNutrients
}

const closeModal = () => {
  emit('closeModal');
  form.clearErrors();
  form.reset();
  loading.value = false;
};

function useItem() {

  const protein = form.foodNutrients.find((fn) => fn.nutrientName.toLowerCase() == 'protein');
  const carbohydrates = form.foodNutrients.find((fn) => fn.nutrientName == 'carbohydrates' || fn.nutrientName.toLowerCase() == 'carbohydrate, by difference');
  const fats = form.foodNutrients.find((fn) => fn.nutrientName == 'fats' || fn.nutrientName.toLowerCase() == 'total lipid (fat)');

  const useItemForm = useForm({
    goal: props.calorieDay.goal,
    count: Math.round(form.calories * form.portionModifier / 100),
    food_items: [{
      description: form.description,
      count: Math.round(form.calories * form.portionModifier / 100),
      protein: Math.round(protein.value * form.portionModifier / 100),
      carbohydrates: Math.round(carbohydrates.value * form.portionModifier / 100),
      fats: Math.round(fats.value * form.portionModifier / 100)
    }]
  });

  useItemForm.put(route('calorieDay.update', props.calorieDay.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`+ ${useItemForm.count} Calories`)
      emit('closeModal');
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

function evaluateQualities() {
  const calories = form.calories;

  const protein = form.foodNutrients.find(f => f.nutrientName == 'protein');
  const carbs = form.foodNutrients.find(f => f.nutrientName == 'carbohydrates');
  const fats = form.foodNutrients.find(f => f.nutrientName == 'fats');
  protein.title = "Protein"
  carbs.title = "Carb"
  fats.title = "Fat"

  const macros = [protein, carbs, fats];
  const percentages = [.10, .26, .30];

  let qualities = '';
  macros.forEach((m, index) => {
    if (m.value != 0) {
      if (calories * percentages[index] <= m.value) {
        qualities += ('high' + m.title + ',')
      } else {
        qualities += ('low' + m.title + ',')
      }
    }
  });

  return qualities
}

function createFoodItem() {

  if (!form.servingSizeUnit) {
    form.servingSize = form.portionModifier;
    form.servingSizeUnit = 'g';
  }

  const evaluatedQualities = evaluateQualities();

  form.transform((data) => ({
    ...data,
    qualities: evaluatedQualities,
    calories: Math.round(data.calories * data.portionModifier / 100),
    foodNutrients: data.foodNutrients.map(n => ({
      ...n,
      value: Math.round(n.value * data.portionModifier / 100)
    }))
  }))
    .post(route('foodItem.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Pop.success(`${form.description} created`);
        closeModal();
      },
      onError: (errors) => {
        console.log(errors);
      },
    });
};

</script>


<template>

  <UsdaFoodDetailsForm v-if="!errorPage" :formData="form" @cancel="closeModal" :loading="loading" @useItem="useItem"
    @createFoodItem="createFoodItem">
    <template #title>
      <h1 v-if="!loading" class="text-center text-base font-bold text-gray-700">Edit <span class="text-xl text-black">{{
        form.description }}</span>?
      </h1>
      <h1 v-else class="text-center text-xl font-bold">Loading</h1>
    </template>

    <SecondaryButton type="button" @click="closeModal">
      Cancel
    </SecondaryButton>

  </UsdaFoodDetailsForm>

  <div v-else class="text-special text-2xl">
    No foods were found.
  </div>

</template>