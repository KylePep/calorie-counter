<script setup>
import UsdaFoodCardButton from "./UsdaFoodCardButton.vue";

const props = defineProps(['foodItems']);

const emit = defineEmits(['increase-by', 'extraButton'])

function emitIncreaseBy(item) {
  if (item.gtinUpc) {
    item.calories = getBrandedCalories(item)
  } else {
    item.calories = getCalories(item)
  }
  emit('increase-by', item);
}

function extraButton(item, purpose) {
  if (item.gtinUpc) {
    item.calories = getBrandedCalories(item)
  } else {
    item.calories = getCalories(item)
  }
  emit('extraButton', item, purpose);
}

const getCalories = (item) => {
  const energy = item.foodNutrients.find(fn => fn.nutrientName == 'Energy' && fn.unitName == 'KCAL');
  if (!energy) {
    return 0
  }
  return energy.value;
}

const getBrandedCalories = (item) => {
  const energy = getCalories(item);
  const caloriesToSize = energy * (item.servingSize * .01);
  return Math.round(caloriesToSize);
}

</script>


<template>



  <div v-for="item in foodItems" :key="item.fdcId">

    <section @click="emitIncreaseBy(item)"
      class="flex flex-col break-inside-avoid hover:bg-gray-200 bg-gray-300  rounded-t border-4 border-black/25 pb-3 min-h-40">

      <div class="flex items-center justify-between bg-gray-200 px-1 border-b-2 border-black/25">

        <div class=" text-gray-800 font-bold text-3xl drop-shadow-2xl">
          <template v-if="item.gtinUpc != 0">
            {{ getBrandedCalories(item) }}
          </template>
          <template v-else>
            {{ getCalories(item) }}
          </template>
        </div>

        <UsdaFoodCardButton @click.stop="extraButton(item, 'edit')" icon="pencil">Edit</UsdaFoodCardButton>
        <UsdaFoodCardButton @click.stop="extraButton(item, 'favorite')" icon="star">Favorite</UsdaFoodCardButton>
        <UsdaFoodCardButton @click.stop="emitIncreaseBy(item)" icon="plus">Add</UsdaFoodCardButton>

      </div>

      <div class=" text-gray-800 font-bold p-3 drop-shadow-2xl my-auto">
        <h1 class="font-bold" :class="[item.gtinUpc ? 'text-base' : 'text-lg']">{{ item.description }}</h1>
        <p class="text-xs" v-if="item.gtinUpc && item.brandOwner">
          ( {{ item.brandName + [item.brandName ? ' by' : ''] }} {{ item.brandOwner }} )
        </p>
      </div>

    </section>

    <section
      class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-1 p-1 border-4 border-t-0 border-black/25 bg-gray-300">
      <div v-for="block in Math.round([item.gtinUpc ? getBrandedCalories(item) : getCalories(item)] / 50) "
        class="bg-gray-400 h-4 border-2 border-black/25 rounded-sm">
      </div>
    </section>



  </div>
</template>
