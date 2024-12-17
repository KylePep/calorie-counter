<script setup>
import FoodCard from "./FoodCard.vue";

const props = defineProps(['account', 'mealType', 'foodItems', 'percent', 'bgColor'])

const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}
</script>


<template>
  <div>

    <div :class="props.bgColor" class=" text-dark-text px-2 py-1 rounded">
      <slot /> - Calories {{ (account.goal * (percent / 100)).toFixed(0) }}
    </div>

    <div v-for="item in foodItems">
      <FoodCard :foodItem="item" @set-active="setActive" />
    </div>

  </div>
</template>