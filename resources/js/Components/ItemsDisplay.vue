<script setup>
import { computed, ref } from "vue";
import FoodCard from "./FoodComponents/FoodCard.vue";

const props = defineProps(['list', 'size']);
const emit = defineEmits(['itemActivated', 'extraButton'])

const currentSize = ref(props.size);
const showItems = ref(true);

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function handleExtraButton(item, action) {
  emit('extraButton', item, action);
}


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

  <div class="grid">

    <div class="flex justify-between">
      <div @click="showItems = !showItems" :class="showItems ? 'border-b-gray-200 rounded-t' : 'rounded'"
        class="flex justify-between border-2 p-1 border-gray-300 w-48 sm:w-60">
        <slot />
        <i :class="showItems ? 'mdi mdi-menu-up' : 'mdi mdi-menu-down'" class="mx-2  text-lg"></i>
      </div>

      <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="showItems" class="flex items-center space-x-2 ">
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
      </Transition>
    </div>

    <Transition enter-active-class="ease-out duration-300" enter-from-class="scale-y-0 max-h-0 opacity-0"
      enter-to-class="scale-y-100 max-h-[1000px] opacity-100" leave-active-class="ease-in duration-200"
      leave-from-class="scale-y-100 max-h-[1000px] opacity-100" leave-to-class="scale-y-0 max-h-0 opacity-0">

      <div v-show="showItems"
        class="origin-top grid grid-flow-col auto-cols-min gap-3 p-2 text-center bg-gradient-to-b from-gray-200 via-white  border-2 rounded-b-lg rounded-tr-lg border-gray-300 overflow-x-auto whitespace-nowrap shadow-inner"
        :class="currentSizeClass">

        <div v-for="foodItem in props.list">
          <FoodCard :foodItem="foodItem" @itemActivated="emitItemActivated" @extraButton="handleExtraButton" />
        </div>

        <div v-if="props.list.length == 0"
          class="inline-block justify-center text-center min-h-36 w-60 hover:bg-gray-200 bg-gray-300 rounded ">
          <div class="flex flex-col min-h-36 justify-around">
            <p>
              No Recent Foods
            </p>
          </div>
        </div>
      </div>
    </Transition>

  </div>

</template>
