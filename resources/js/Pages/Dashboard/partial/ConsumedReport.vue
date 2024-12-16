<script setup>
import { computed, reactive, ref } from "vue";

const props = defineProps(['account', 'calorieDays']);

const calorieDaysToSort = reactive([...props.calorieDays]);

const tooLow = computed(() => {
  return calorieDaysToSort.filter((day) => day.count < day.goal && day.count != 0);
});

const tooHigh = computed(() => {
  return calorieDaysToSort.filter((day) => day.count > day.bmr);
});

const successful = computed(() => {
  return calorieDaysToSort.filter((day) => day.count > day.goal && day.count < day.bmr);
});

function commonFoods(list) {
  const foodCounts = {};

  list.forEach((day) => {
    day.food_items.forEach((food) => {
      const description = food.description;
      foodCounts[description] = (foodCounts[description] || 0) + 1;
    });
  });

  const sortedFoods = Object.entries(foodCounts)
    .sort((a, b) => b[1] - a[1])
    .slice(0, 5);

  return sortedFoods;
}

function transparencyClass(color, index) {
  if (color == 'accent') {
    return {
      0: 'bg-accent',
      1: 'bg-accent/80',
      2: 'bg-accent/60',
      3: 'bg-accent/40',
      4: 'bg-accent/20',
    }[index]
  }
  if (color == 'accent-light') {
    return {
      0: 'bg-accent-light',
      1: 'bg-accent-light/80',
      2: 'bg-accent-light/60',
      3: 'bg-accent-light/40',
      4: 'bg-accent-light/20',
    }[index]
  }
  if (color == 'accent-dark') {
    return {
      0: 'bg-accent-dark',
      1: 'bg-accent-dark/80',
      2: 'bg-accent-dark/60',
      3: 'bg-accent-dark/40',
      4: 'bg-accent-dark/20',
    }[index]
  }
}

</script>


<template>
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12 space-y-8">
    <div>
      <h1 class="font-bold">
        Consumed Report
      </h1>
      <h2>
        From the last 31 available entries here are the foods that showed up the most.
      </h2>
    </div>
    <div v-if="successful.length" class="space-y-2">
      <h3 class="font-semibold bg-light px-2 py-1 rounded-sm">
        Within your goals range
      </h3>

      <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
        <button v-for="item, index in commonFoods(successful)" :class="transparencyClass('accent', index)"
          class="grid grid-cols-10 focus:col-span-3 p-1 rounded items-start shadow-lg">

          <div class="text-dark text-xs font-bold px-2 text-start">
            {{ index + 1 }}
          </div>
          <div class="col-span-9 truncate font-semibold text-sm px-2">
            {{ item[0] }}
            <div class="text-xs">
              {{ item[1] }} times
            </div>
          </div>
        </button>
      </div>

    </div>


    <div v-if="tooLow.length" class="space-y-2">
      <h4 class="font-semibold bg-light px-2 py-1 rounded-sm">
        Lower than your goal - {{ account.goal }}
      </h4>

      <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
        <button v-for="item, index in commonFoods(tooLow)" :class="transparencyClass('accent-light', index)"
          class="grid grid-cols-10 focus:col-span-3 p-1 rounded items-start shadow-lg">

          <div class="text-dark text-xs font-bold px-2 text-start">
            {{ index + 1 }}
          </div>
          <div class="col-span-9 truncate font-semibold text-sm px-2">
            {{ item[0] }}
            <div class="text-xs">
              {{ item[1] }} times
            </div>
          </div>
        </button>
      </div>
    </div>


    <div v-if="tooHigh.length" class="space-y-2">
      <h5 class="font-semibold bg-light px-2 py-1 rounded-sm">
        Higher than your BMR - {{ account.bmr }}
      </h5>

      <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
        <button v-for="item, index in commonFoods(tooHigh)" :class="transparencyClass('accent-dark', index)"
          class="grid grid-cols-10 focus:col-span-3 p-1 rounded items-start shadow-lg">

          <div class="text-white text-xs font-bold px-2 text-start">
            {{ index + 1 }}
          </div>
          <div class="col-span-9 text-white truncate font-semibold text-sm px-2">
            {{ item[0] }}
            <div class="text-xs">
              {{ item[1] }} times
            </div>
          </div>
        </button>
      </div>
    </div>

    <div v-if="!successful.length && !tooLow.length && !tooHigh.length">
      <h6 class="fond-semibold bg-light px-2 py-1 rounded-sm text-center">Not enough food items entered to generate
        report, Keep
        counting!</h6>
    </div>

  </div>
</template>


<style lang="scss" scoped></style>