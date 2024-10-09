<script setup>
import { computed } from "vue";

const props = defineProps(['dayItems'])
defineEmits(['removeFoodItem'])

const firstRow = computed(() => props.dayItems.filter((_, index) => index % 3 === 0));
const secondRow = computed(() => props.dayItems.filter((_, index) => index % 3 === 1));
const thirdRow = computed(() => props.dayItems.filter((_, index) => index % 3 === 2));

</script>

<template>
  <h1 class="text-xl font-bold pb-3">Eaten</h1>
  <div
    class=" p-2 grid grid-rows-3 text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap gap-1 ">
    <div class="flex space-x-2">
      <div v-for="(item, index) in firstRow" :key="index" @click="$emit('removeFoodItem', item)"
        class="group hover:bg-gray-400 h-8 inline-block bg-gray-300 rounded-lg px-2 flex items-center justify-center duration-500 w-min">

        <p class="relative text-xs group-hover:text-black/25 font-bold duration-400">
          {{ item.description }} - {{ item.count }} Calories
        <p
          class="absolute w-full top-0 group-hover:text-white text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>
        </p>

      </div>
    </div>
    <div class="flex space-x-2">
      <div v-for="(item, index) in secondRow" :key="index" @click="$emit('removeFoodItem', item)"
        class="group hover:bg-gray-400 h-8 inline-block bg-gray-300 rounded-lg px-2 flex items-center justify-center duration-500 w-min">

        <p class="relative text-xs group-hover:text-black/25 font-bold duration-400">
          {{ item.description }} - {{ item.count }} Calories
        <p
          class="absolute w-full top-0 group-hover:text-white text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>
        </p>

      </div>
    </div>
    <div class="flex space-x-2">
      <div v-for="(item, index) in thirdRow" :key="index" @click="$emit('removeFoodItem', item)"
        class="group hover:bg-gray-400 h-8 inline-block bg-gray-300 rounded-lg px-2 flex items-center justify-center duration-500 w-min">

        <p class="relative text-xs group-hover:text-black/25 font-bold duration-400">
          {{ item.description }} - {{ item.count }} Calories
        <p
          class="absolute w-full top-0 group-hover:text-white text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>
        </p>

      </div>
    </div>



  </div>
</template>
