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

  <div class=" p-2 grid grid-rows-2 text-center overflow-x-auto whitespace-nowrap gap-1 ">
    <div v-for="rowIndex in 2" class="flex space-x-1">
      <button v-for="(item, index) in rowIndex == 1 ? firstRow : secondRow" :key="index"
        @click="$emit('removeFoodItem', item)" :class="representativeWidth(item)"
        :title="`${item.description}  -${item.count} Calories`"
        class="group relative hover:bg-dark h-8 inline-block bg-main border border-light rounded-sm px-2 flex items-center justify-center duration-500 overflow-hidden shadow-lg">

        <p ref="scrollingText" :class="getAnimationClass(item)"
          class=" relative text-xs group-hover:text-neutral-text ps-3 font-bold duration-400">
          {{ item.description }}
        </p>
        <p
          class="absolute left-1/2  object-center group-hover:text-accent text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </button>
    </div>

  </div>
</template>
