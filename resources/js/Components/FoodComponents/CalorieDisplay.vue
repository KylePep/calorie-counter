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
    neutral: 'bg-light text-transparent sm:text-neutral/75 border-neutral',
    used: 'bg-accent text-transparent border-neutral',
    modified: 'bg-light border-accent-yellow border-4 text-transparent sm:text-neutral/75',
    modifyUsed: 'bg-accent text-transparent border-accent-yellow border-4'
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
    neutral: 'bg-light text-neutral/75 border-neutral',
    used: 'bg-special text-transparent border-neutral',
  }[selector]
};

</script>

<template>

  <section id="calorie display"
    class="z-10 relative p-1.5 rounded border-2 border border-light drop-shadow-xl bg-gradient-to-b from-main via-light to-light"
    :class="calorieCount < bmr ? 'sticky top-16' : ''">
    <div class="grid grid-cols-10 gap-1">
      <div v-for="cell in allCellsTotal" class="h-10 text-sm border border-dark bg-neutral "></div>
    </div>

    <div class="absolute top-0 left-0 w-full grid grid-cols-10 gap-1 p-1.5">
      <div v-for="cell in cellCount" :class="cellClasses(cell)"
        class="h-10 flex justify-center items-center text-sm  border font-bold  duration-500" :title="cell * 100">
        100
      </div>
    </div>

  </section>

  <section id="extra calorie display" v-if="calorieCount > bmr"
    class="sticky top-16 z-20 p-1.5 rounded border-2 border border-light drop-shadow-xl bg-gradient-to-b from-main via-light to-light">

    <div class=" grid grid-cols-10 gap-1">
      <div v-for="index in 20" :class="cellsOverClasses(index)"
        class="h-10 flex justify-center items-center text-sm  border font-bold  duration-500"
        :title="index * 100 + bmr">
        100
      </div>
    </div>

  </section>

</template>
