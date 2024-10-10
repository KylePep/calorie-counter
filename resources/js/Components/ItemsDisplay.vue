<script setup>
import { computed, ref } from "vue";
import FoodCard from "./FoodComponents/FoodCard.vue";

const emit = defineEmits(['itemActivated'])

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function handleExtraButton(item, action) {
  if (action == 'edit') {

  } else if (action == 'add') {

  } else {

  }
}

const props = defineProps(['list', 'size']);
const currentSize = ref(props.size)

const maxSize = computed(() => {
  if (props.list.length < 5 && props.list.length >= 0) {
    return 'sm'
  } else if (props.list.length < 8) {
    return 'lg'
  } else {
    return 'xl'
  }
})

const currentSizeClass = computed(() => {
  let newSize = {
    sm: 'grid-rows-1',
    lg: 'grid-rows-2',
    xl: 'grid-rows-3',
  }[currentSize.value];

  if (maxSize.value == 'lg') {
    if (currentSize.value == 'xl') {
      newSize = 'lg'
      currentSize.value = 'lg'
    }
  } else if (maxSize.value == 'sm') {
    if (currentSize.value == 'xl' || currentSize.value == 'lg') {
      newSize = 'sm'
      currentSize.value = 'sm'
    }
  }

  return newSize;
});

</script>

<template>


  <div class="flex justify-between mb-3">
    <slot />

    <div class="flex items-center space-x-2 ">
      <button @click="currentSize = 'sm'"
        :class="[currentSize == 'sm' ? 'bg-gray-500' : 'bg-gray-900 hover:bg-gray-700']"
        class="text-white rounded-md px-3 mdi mdi-crop-square"></button>
      <button v-if="maxSize == 'lg' || maxSize == 'xl'" @click="currentSize = 'lg'"
        :class="[currentSize == 'lg' ? 'bg-gray-500' : 'bg-gray-900 hover:bg-gray-700']"
        class="text-white rounded-md px-3 mdi mdi-grid-large"></button>
      <button v-if="maxSize == 'xl'" @click="currentSize = 'xl'"
        :class="[currentSize == 'xl' ? 'bg-gray-500' : 'bg-gray-900 hover:bg-gray-700']"
        class="text-white rounded-md px-3 mdi mdi-grid"></button>
    </div>
  </div>

  <div
    class="grid grid-flow-col gap-3 min-h-40 p-2 text-center border-2 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap"
    :class="currentSizeClass">
    <FoodCard :foodItems="props.list" @itemActivated="emitItemActivated" @extraButton="handleExtraButton" />
    <div v-if="props.list.length == 0"
      class="inline-block justify-center text-center min-h-36 w-60 hover:bg-gray-200 bg-gray-300 rounded ">
      <div class="flex flex-col min-h-36 justify-around">
        <p>
          No Recent Foods
        </p>
      </div>
    </div>
  </div>
</template>
