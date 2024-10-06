<script setup lang="ts">
defineEmits(['increaseBy'])

const props = defineProps(['without_fdcId', 'size'])
</script>

<template>
  <h1 class="text-xl font-bold pb-3">Your Foods</h1>
  <div class="min-h-40 p-2 text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap ">
    <div @click="$emit('increaseBy', foodItem)" v-for="foodItem in without_fdcId" :key="foodItem.id"
      class="inline-block justify-center text-center min-h-36 w-60 hover:bg-gray-200 bg-gray-300 rounded m-2">
      <div class="flex flex-col min-h-36 justify-around">
        <p>
          {{ foodItem.description }}
        </p>
        <p>
          calories: {{ foodItem.calories }}
        </p>
      </div>
    </div>
    <div v-if="without_fdcId.length == 0"
      class="inline-block justify-center text-center min-h-36 w-60 hover:bg-gray-200 bg-gray-300 rounded m-2">
      <div class="flex flex-col min-h-36 justify-around">
        <p>
          No Recent Foods
        </p>
      </div>
    </div>
  </div>
</template>
