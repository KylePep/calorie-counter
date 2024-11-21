<script setup>
import { computed, ref } from "vue";

const props = defineProps(['goal', 'calorieCount', 'bmr']);

const cellCount = ref(Math.ceil(props.bmr / 100));
const calorieCountRows = ref(Math.ceil(props.bmr / 1000));

const allCellsTotal = computed(() => calorieCountRows.value * 10)

function cellClasses(value) {
  let selector = '';
  const trueValue = value * 100;

  if (trueValue > props.calorieCount) {
    selector = 'neutral';
  } else {
    selector = 'used';
  }

  if (props.bmr != props.goal) {
    if (trueValue >= props.goal) {
      if (trueValue > props.calorieCount) {
        selector = 'modified';
      } else {
        selector = 'modifyUsed';
      }
    }
  }

  return {
    neutral: 'bg-light text-transparent sm:text-neutral-text/40 border-neutral/50',
    used: 'bg-accent text-transparent border-accent-dark',
    modified: 'bg-light border-accent-light border-4 text-transparent sm:text-neutral-text/40',
    modifyUsed: 'bg-accent-light text-transparent border-accent'
  }[selector]
};

function cellsOverClasses(value) {
  let selector = '';
  const trueValue = value * 100 + props.bmr;

  if (trueValue > props.calorieCount) {
    selector = 'neutral';
  } else {
    selector = 'used';
  }

  return {
    neutral: 'bg-light text-transparent sm:text-neutral-text/40 border-neutral/50',
    used: 'bg-special/75 text-transparent border-special',
  }[selector]
};

</script>

<template>

  <section id="calorie display" class="z-10 relative p-1.5 rounded border border border-light drop-shadow-xl bg-main"
    :class="calorieCount < bmr ? 'sticky top-20' : ''">
    <div class="grid grid-cols-10 gap-1">
      <div v-for="cell in allCellsTotal" class="h-6 sm:h-10 text-sm bg-light/10 border-4 border-light/10 rounded-sm">
      </div>
    </div>

    <div class="absolute top-0 left-0 w-full grid grid-cols-10 gap-1 p-1.5">
      <div v-for="cell in cellCount" :class="cellClasses(cell)"
        class="h-6 sm:h-10 flex justify-center items-center text-sm  border-4 rounded-sm font-bold  duration-500"
        :title="cell * 100">
        100
      </div>
    </div>

  </section>

  <section id="extra calorie display" v-if="calorieCount > bmr"
    class="sticky top-20 z-20 p-1.5 rounded border border-light drop-shadow-xl bg-main">

    <div class=" grid grid-cols-10 gap-1">
      <div v-for="index in 20" :class="cellsOverClasses(index)"
        class="h-6 sm:h-10 flex justify-center items-center text-sm border-4 rounded-sm font-bold  duration-500"
        :title="index * 100 + bmr">
        100
      </div>
    </div>

  </section>

</template>
