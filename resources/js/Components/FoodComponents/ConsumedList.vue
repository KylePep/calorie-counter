<script setup>
import { computed, ref } from "vue";
import Pop from "@/utils/Pop.js";

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

  <section class="flex justify-between">
    <h1>Consumed</h1>
  </section>

  <section>
    <div v-if="!displayList" class=" py-2 grid grid-rows-2 text-center overflow-x-auto whitespace-nowrap gap-1 ">
      <div v-for="rowIndex in 2" class="flex space-x-1">
        <button v-for="(item, index) in rowIndex == 1 ? firstRow : secondRow" :key="index"
          @click="confirmRemoveItem(item)" :class="representativeWidth(item)"
          :title="`${item.description}  -${item.count} Calories`"
          class="group relative hover:bg-dark h-8 inline-block bg-white border border-light rounded-sm px-2 flex items-center justify-center duration-500 overflow-hidden shadow-lg">

          <div class="relative">
            <p ref="scrollingText" :class="getAnimationClass(item, 'start')"
              class="text-neutral-text text-xs text-center font-bold duration-400">
              {{ item.description }}
            </p>
            <p ref="scrollingText" :class="getAnimationClass(item, 'end')"
              class="absolute top-0 text-neutral-text text-xs ps-2 font-bold duration-400">
              {{ item.description }}
            </p>
          </div>
          <span
            class="absolute w-full group-hover:text-special text-transparent font-bold mdi mdi-close-thick duration-300">
          </span>

        </button>
      </div>
    </div>

    <div v-else class="grid grid-cols-2 sm:grid-cols-3 gap-2">
      <button v-for="(item, index) in dayItems" :key="index" @click="confirmRemoveItem(item)"
        class="group relative hover:bg-dark h-8 inline-block bg-white border border-light rounded-sm px-2 flex items-center justify-center duration-500 overflow-hidden shadow-lg">

        <p class=" relative text-neutral-text text-xs group-hover:text-neutral-text ps-3 font-bold duration-400">
          {{ item.description }} - {{ item.count }}
        </p>
        <p class="absolute w-full group-hover:text-special text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </button>
    </div>
  </section>
</template>