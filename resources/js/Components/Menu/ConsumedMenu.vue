<script setup>
import { computed, ref } from "vue";
import CollapsableFolder from "../Displays/CollapsableFolder.vue";
import Pop from "@/utils/Pop.js";
import PrimaryButton from "../Form/PrimaryButton.vue";

const props = defineProps(['dayItems']);
const emit = defineEmits(['removeFoodItem']);

const displayList = ref(false);

const firstRow = computed(() => props.dayItems.filter((_, index) => index % 2 === 0));
const secondRow = computed(() => props.dayItems.filter((_, index) => index % 2 === 1));

function representativeWidth(item) {

  const calorieBy100 = Math.round(item.count / 100) * 100;
  return {
    0: 'w-10',
    100: 'w-10',
    200: 'w-20',
    300: 'w-32',
    400: 'w-40',
    500: 'w-52',
    600: 'w-60',
    700: 'w-72',
    800: 'w-80',
    900: 'w-96',
    1000: 'w-96',
  }[calorieBy100];
}

// Function to return animation class based on conditions
const getAnimationClass = (item, position) => {
  const textWidth = item.description.length + 10;
  const calorieWidth = Number(representativeWidth(item).split('-')[1]);

  if (textWidth > calorieWidth) {
    if (position == 'start')
      return 'animate-marquee-start';
    else
      return 'animate-marquee-end';
  }
  if (position == 'end')
    return 'hidden'
  else
    return '';
}

async function confirmRemoveItem(item) {
  const confirmRemove = await Pop.confirm(`Remove ${item.description} - ${item.count}? `)
  if (!confirmRemove) {
    return;
  }
  emit('removeFoodItem', item);
}

</script>


<template>

  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Consumed List</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">A simple list view of all of your foods for the day an their
      calories.
    </h2>

    <div class="">
      <button v-for="(item, index) in dayItems" :key="index" @click="confirmRemoveItem(item)"
        class="group relative flex justify-center items-center w-full hover:bg-dark bg-white border border-light rounded-sm py-2 duration-500 overflow-hidden shadow-lg mb-1">

        <p
          class="relative grid grid-cols-6 w-full text-neutral-text text-xs group-hover:text-light-text px-3 font-bold duration-400">
          <span class="text-start col-span-5 ">{{ item.description }}</span>
          <span class="text-end">{{ item.count }} cal</span>
        </p>
        <p class="absolute w-full group-hover:text-special text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </button>
    </div>
  </div>
</template>