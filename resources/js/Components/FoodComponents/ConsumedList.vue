<script setup>
import { computed } from "vue";
import { onMounted, ref } from 'vue'

const props = defineProps(['dayItems'])
defineEmits(['removeFoodItem'])

const firstRow = computed(() => props.dayItems.filter((_, index) => index % 2 === 0));
const secondRow = computed(() => props.dayItems.filter((_, index) => index % 2 === 1));

function representativeWidth(item) {

  const calorieBy100 = Math.round(item.count / 100) * 100;
  return {
    0: 'w-10',
    100: 'w-20',
    200: 'w-32',
    200: 'w-40',
    400: 'w-56',
    500: 'w-60',
    600: 'w-72',
    700: 'w-80',
    800: 'w-80',
    900: 'w-80',
    1000: 'w-80',
  }[calorieBy100]
}

// Function to return animation class based on conditions
const getAnimationClass = (item) => {
  const textWidth = item.description.length
  const calorieWidth = Number(representativeWidth(item).split('-')[1])

  if (textWidth > calorieWidth) {
    return 'animate-infinite-scroll'
  }
  return ''
}

</script>

<template>
  <h1 class="text-xl font-bold pb-3">Eaten</h1>
  <div
    class=" p-2 grid grid-rows-2 text-center border-2 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap gap-1 ">
    <div v-for="rowIndex in 2" class="flex space-x-1">
      <div v-for="(item, index) in rowIndex == 1 ? firstRow : secondRow" :key="index"
        @click="$emit('removeFoodItem', item)" :class="representativeWidth(item)"
        :title="`${item.description}  -${item.count} Calories`"
        class="group relative hover:bg-gray-400 h-8 inline-block bg-gray-300 border border-black/20 rounded-sm px-2 flex items-center justify-center duration-500 overflow-hidden">

        <p ref="scrollingText" :class="getAnimationClass(item)"
          class=" relative text-xs group-hover:text-black/25 font-bold duration-400">
          {{ item.description }}
        </p>
        <p
          class="absolute left-1/2  object-center group-hover:text-white text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </div>
    </div>

  </div>
</template>
