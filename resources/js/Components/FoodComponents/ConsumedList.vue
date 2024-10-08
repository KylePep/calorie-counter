<script setup lang="ts">
defineProps<{
  dayItems: any;
}>()
</script>

<template>
  <h1 class="text-xl font-bold pb-3">Eaten</h1>
  <div
    class=" p-2 pb-0 grid grid-rows-3 grid-flow-col text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap gap-1 ">
    <div v-for="(item, index) in dayItems" :key="index"
      class="group hover:bg-gray-400 h-10 inline-block bg-gray-300 rounded-lg px-2 flex items-center justify-center duration-500">

      <p class="relative group-hover:text-black/25 font-bold duration-400">
        {{ item.description }} - {{ item.count }} Calories
      <p
        class="absolute w-full top-0 group-hover:text-white text-transparent font-bold mdi mdi-close-thick duration-300">
      </p>
      </p>

    </div>
  </div>
</template>
