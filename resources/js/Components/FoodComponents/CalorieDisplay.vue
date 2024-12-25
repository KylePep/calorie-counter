<script setup>
import { computed, ref } from "vue";

const props = defineProps(['goal', 'account', 'calorieCount', 'bmr', 'foodItems']);

const cellCount = ref(Math.ceil(props.bmr / 100));
const cellGoalCount = ref(Math.ceil(props.goal / 100));
const calorieCountRows = ref(Math.ceil(props.bmr / 1000));

const allCellsTotal = computed(() => calorieCountRows.value * 10);

const ratiosActive = ref(props.account.ratios.tracking ? true : false);
const breakfastRatio = computed(() => ratiosActive ? props.account.ratios.breakfast : 30);
const lunchRatio = computed(() => ratiosActive ? props.account.ratios.lunch : 30);
const dinnerRatio = computed(() => ratiosActive ? props.account.ratios.dinner : 30);
const otherRatio = computed(() => {
  const total = breakfastPercentage.value + lunchPercentage.value + dinnerPercentage.value;
  return total > 100 ? 0 : 100 - total;
});

const calculateCellRange = (percentage) => Math.round((percentage / 100) * cellGoalCount.value);

const breakfastRange = computed(() => calculateCellRange(breakfastRatio.value));
const lunchRange = computed(() => calculateCellRange(lunchRatio.value));
const dinnerRange = computed(() => calculateCellRange(dinnerRatio.value));
const otherRange = computed(() => allCellsTotal.value - (breakfastRange.value + lunchRange.value + dinnerRange.value));

const calculateCategoryRange = computed(() => {
  let breakfastValue = 0
  let lunchValue = 0
  let dinnerValue = 0
  let otherValue = 0
  props.foodItems.forEach(fI => {
    if (fI.category == 'breakfast') {
      breakfastValue += fI.count
    } else if (fI.category == 'lunch') {
      lunchValue += fI.count
    } else if (fI.category == 'dinner') {
      dinnerValue += fI.count
    } else {
      otherValue += fI.count
    }
  });

  return {
    breakfast: breakfastValue,
    lunch: lunchValue,
    dinner: dinnerValue,
    other: otherValue,
  }
})

function cellClasses(value) {
  let selector = '';
  const trueValue = value * 100;

  if (trueValue > props.calorieCount) {
    selector = 'neutral';
  } else {
    selector = 'used';
  }

  if (props.bmr != props.goal) {
    if (trueValue > Math.round(props.goal / 100) * 100) {
      if (trueValue > props.calorieCount) {
        selector = 'modified';
      } else {
        selector = 'modifyUsed';
      }
    }
  }

  return {
    neutral: neutralClasses(value),
    used: usageClass(trueValue),
    modified: modifiedClasses(value),
    modifyUsed: modifyUsedClasses(value)
  }[selector]
};

function neutralClasses(value) {
  if (!ratiosActive.value) {
    return 'bg-light text-transparent sm:text-neutral-text/40 border-neutral/50'
  } else {
    if (value < breakfastRange.value) {
      return "bg-accent-light/10 border-accent-light/25 text-transparent";
    } else if (value < breakfastRange.value + lunchRange.value) {
      return "bg-accent/10 border-accent/25 text-transparent";
    } else if (value < breakfastRange.value + lunchRange.value + dinnerRange.value) {
      return "bg-accent-dark/10 border-accent-dark/25 text-transparent";
    } else {
      return "bg-special/10 border-special/25 text-transparent";
    }
  }
}

function usageClass(value) {
  if (!ratiosActive.value) {
    return 'bg-accent/75 text-transparent border-accent'
  } else {
    if (value < calculateCategoryRange.value.breakfast) {
      return "bg-accent-light/75 border-accent-light text-transparent";
    } else if (value < calculateCategoryRange.value.breakfast + calculateCategoryRange.value.lunch) {
      return "bg-accent/75 border-accent text-transparent";
    } else if (value < calculateCategoryRange.value.breakfast + calculateCategoryRange.value.lunch + calculateCategoryRange.value.dinner) {
      return "bg-accent-dark/75 border-accent-dark text-transparent";
    } else {
      return "bg-special/75 border-special text-transparent";
    }
  }
}

function modifiedClasses(value) {
  if (!ratiosActive.value) {
    return 'bg-light border-accent-light border-4 text-transparent sm:text-neutral-text/40'
  } else {
    return 'bg-light/10 border-alert/50 text-transparent sm:text-neutral-text/40'
  }
}

function modifyUsedClasses(value) {
  if (!ratiosActive.value) {
    return 'bg-accent-light text-transparent border-accent'
  } else {
    return 'bg-alert/50 border-alert/50 text-transparent'
  }
}

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
    :class="calorieCount < bmr ? 'sticky top-20 lg:top-32' : ''">
    <div class="grid grid-cols-10 gap-1">
      <div v-for="cell, index in allCellsTotal" :key="index"
        class="h-6 sm:h-10 text-sm bg-light/10 border-4 border-light/10 rounded-sm">
      </div>
    </div>

    <div class="absolute top-0 left-0 w-full grid grid-cols-10 gap-1 p-1.5">
      <div v-for="cell, index in cellCount" :key="index" :class="cellClasses(cell)"
        class="h-6 sm:h-10 flex justify-center items-center text-sm  border-4 rounded-sm font-bold  duration-500"
        :title="cell * 100">
        100
      </div>
    </div>

  </section>

  <section id="extra calorie display" v-if="calorieCount > bmr"
    class="sticky top-20 z-10 p-1.5 rounded border border-light drop-shadow-xl bg-main">

    <div class=" grid grid-cols-10 gap-1">
      <div v-for="index in 20" :key="index" :class="cellsOverClasses(index)"
        class="h-6 sm:h-10 flex justify-center items-center text-sm border-4 rounded-sm font-bold  duration-500"
        :title="index * 100 + bmr">
        100
      </div>
    </div>

  </section>

</template>
