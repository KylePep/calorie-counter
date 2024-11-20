<script setup>
import { computed, ref } from "vue";
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";
import SizeButton from './SizeButton.vue';
import Dropdown from "../Form/Dropdown.vue";

const props = defineProps(['list', 'size']);
const emit = defineEmits(['itemActivated', 'extraButton']);

const currentSize = ref(props.size);

const filter = ref('All');

const filteredList = computed(() => {
  if (filter.value != 'All') {
    return props.list.filter((li) => li.foodCategory == filter.value.toLocaleLowerCase());
  } else return props.list;
});

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function handleExtraButton(item, action) {
  emit('extraButton', item, action);
}


const maxSize = computed(() => {
  if (props.list.length < 5 && props.list.length >= 0) {
    return 'sm';
  } else if (props.list.length < 8) {
    return 'lg';
  } else {
    return 'xl';
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

const scrollContainer = ref(null);
let isDragging = false;
let startX = 0;
let scrollLeft = 0;

const startDragging = (event) => {
  isDragging = true;
  startX = event.pageX - scrollContainer.value.offsetLeft;
  scrollLeft = scrollContainer.value.scrollLeft;
  scrollContainer.value.classList.add('cursor-grabbing');
};

const drag = (event) => {
  if (!isDragging) return;
  event.preventDefault();
  const x = event.pageX - scrollContainer.value.offsetLeft;
  const walk = (x - startX) * 1.5;
  scrollContainer.value.scrollLeft = scrollLeft - walk;
};

const stopDragging = () => {
  isDragging = false;
  scrollContainer.value.classList.remove('cursor-grabbing');
};

</script>

<template>

  <section class="grid grid-cols-10 gap-1 bg-light rounded p-1">

    <div class="col-span-3 sm:col-span-2 flex items-center">
      <Dropdown align="left" width="100" class="w-full">

        <template #trigger>
          <button type="button"
            class="w-full h-8 flex justify-between items-center px-2 py-2  rounded text-xs font-bold text-dark-text hover:text-accent uppercase hover:bg-dark transition ease-in-out duration-150">
            <p class="flex-1 flex items-center text-center">
              {{ filter }}
            </p>
            <i class="mdi mdi-menu-down text-lg"></i>
          </button>
        </template>

        <template #content>
          <div class="flex flex-col p-2 bg-neutral rounded text-light-text text-xs">
            <button class="text-start p-1" :class="[filter == 'All' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'All'">All</button>
            <button class="text-start p-1" :class="[filter == 'Breakfast' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Breakfast'">Breakfast</button>
            <button class="text-start p-1" :class="[filter == 'Lunch' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Lunch'">Lunch</button>
            <button class="text-start p-1" :class="[filter == 'Dinner' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Dinner'">Dinner</button>
            <button class="text-start p-1" :class="[filter == 'Beverage' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Beverage'">Beverage</button>
            <button class="text-start p-1" :class="[filter == 'Snack' ? 'border border-black/25 rounded' : '']"
              type="button" @click="filter = 'Snack'">Snack</button>
          </div>
        </template>

      </Dropdown>
    </div>

    <div class="col-start-7 col-span-4 flex justify-end items-center space-x-2 ">
      <SizeButton v-model:currentSize="currentSize" size="sm" />
      <div v-if="maxSize == 'lg' || maxSize == 'xl'" @click="currentSize = 'lg'">
        <SizeButton v-model:currentSize="currentSize" size="lg" />
      </div>
      <div v-if="maxSize == 'xl'" @click="currentSize = 'xl'">
        <SizeButton v-model:currentSize="currentSize" size="xl" />
      </div>
    </div>

  </section>




  <section ref="scrollContainer"
    class="select-none grid grid-flow-col auto-cols-min gap-1 sm:gap-3 py-2 text-center overflow-x-auto whitespace-nowrap cursor-grab"
    :class="currentSizeClass" @mousedown="startDragging" @mousemove="drag" @mouseup="stopDragging"
    @mouseleave="stopDragging">

    <div v-for="foodItem in filteredList">
      <FoodCard :foodItem="foodItem" @itemActivated="emitItemActivated" @extraButton="handleExtraButton" />
    </div>

    <div v-if="filteredList.length == 0"
      class="inline-block justify-center text-center text-light-text font-bold w-60 bg-neutral border border-light rounded drop-shadow-lg">
      <div class="flex flex-col min-h-24 justify-around">
        <p>
          No foods to show
        </p>
      </div>
    </div>
  </section>

</template>
