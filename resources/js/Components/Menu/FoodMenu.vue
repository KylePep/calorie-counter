<script setup>
import { computed, ref } from "vue";
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";

const props = defineProps(['list', 'size']);
const emit = defineEmits(['itemActivated', 'extraButton']);

const currentSize = ref('xl');

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function handleExtraButton(item, action) {
  emit('extraButton', item, action);
}


const maxSize = 'xl'

const currentSizeClass = computed(() => {
  let newSize = {
    sm: 'grid-rows-1',
    lg: 'grid-rows-2',
    xl: 'grid-rows-3',
  }[currentSize.value];

  if (maxSize.value == 'lg') {
    if (currentSize.value == 'xl') {
      newSize = 'lg';
      currentSize.value = 'lg';
    }
  } else if (maxSize.value == 'sm') {
    if (currentSize.value == 'xl' || currentSize.value == 'lg') {
      newSize = 'sm';
      currentSize.value = 'sm';
    }
  }

  return newSize;
});
</script>



<template>
  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Your Foods</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">
      Filter and search your foods.
    </h2>

    <section class=" grid grid-flow-col auto-cols-min gap-1 sm:gap-3 py-2 text-center overflow-x-auto whitespace-nowrap"
      :class="currentSizeClass">

      <div v-for="foodItem in props.list">
        <FoodCard :foodItem="foodItem" @itemActivated="emitItemActivated" @extraButton="handleExtraButton" />
      </div>

      <div v-if="props.list.length == 0"
        class="inline-block justify-center text-center text-light-text font-bold w-60 bg-neutral border border-light rounded drop-shadow-lg">
        <div class="flex flex-col min-h-24 justify-around">
          <p>
            No foods to show
          </p>
        </div>
      </div>
    </section>
  </div>

</template>