<script setup>
import FoodResultCard from "./FoodResultCard.vue";

const props = defineProps(['account', 'mealType', 'foodItems', 'percent', 'bgColor'])

const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}
</script>


<template>
  <div>

    <div :class="props.bgColor" class=" text-dark-text px-2 py-1 mb-2 rounded">
      <slot /> - Calories {{ (account.goal * (percent / 100)).toFixed(0) }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <div v-for="item in foodItems">
        <FoodResultCard :foodItem="item" @set-active="setActive" />
      </div>
    </div>

    <div v-if="!foodItems.length">
      No Items match your ratio, sorry :/
    </div>

  </div>
</template>