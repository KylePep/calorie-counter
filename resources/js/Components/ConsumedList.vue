<script setup lang="ts">
defineProps<{
  dayItems: any;
}>()
</script>

<template>
  <h1 class="text-xl font-bold pb-3">Eaten</h1>
  <div
    class=" p-2 pb-0 grid grid-rows-3 grid-flow-col gird- text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap gap-1">
    <div v-for="item in dayItems" :key="item" class="inline-block bg-gray-300 rounded-lg px-2">
      <p class="max-h-10 overflow-hidden font-bold">
        {{ item }}
      </p>

    </div>
  </div>
</template>
