<script setup>
import { computed, reactive, ref } from "vue";

const props = defineProps(['account', 'calorieDays']);

const calorieDaysToSort = reactive([...props.calorieDays]);

const tooLow = computed(() => {
  return calorieDaysToSort.filter((day) => day.count < day.goal);
});

const tooHigh = computed(() => {
  return calorieDaysToSort.filter((day) => day.count > day.bmr);
});

const successful = computed(() => {
  return calorieDaysToSort.filter((day) => day.count > day.goal && day.count < day.bmr);
});

const getDayOfWeek = (date) => {
  const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  return daysOfWeek[date];
};

const formattedDate = (day) => {
  return new Date(day.created_at).toLocaleDateString(props.account.timeZone, {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit'
  });
};

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
    <h1 class="font-bold">
      Consumed Report
    </h1>
    <h2>
      Find out what kind of foods are leading to success!
    </h2>
    <div class="bg-light p-2 rounded">
      <h3 class="font-bold">
        Good days
      </h3>

      <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
        <div v-for="item, index in commonFoods(successful)" :class="transparencyClass('accent', index)"
          class="p-2 border border-dark rounded">

          <div class="truncate font-semibold text-sm">
            {{ index + 1 }} - {{ item[0] }}
          </div>
          <div class="text-xs">
            {{ item[1] }} times
          </div>
        </div>
      </div>

    </div>
    <div class="bg-light p-2 rounded space-y-4">
      <h3 class="font-bold">
        Bad days
      </h3>

      <div class="bg-main p-1 rounded">
        <h4 class="font-semibold">
          Too Low
        </h4>

        <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
          <div v-for="item, index in commonFoods(tooLow)" :class="transparencyClass('accent-light', index)"
            class="p-2 border border-dark rounded">
            <div class="truncate font-semibold text-sm">
              {{ item[0] }}
            </div>
            <div class="text-xs">
              {{ item[1] }} times
            </div>
          </div>
        </div>
      </div>


      <div class="bg-main p-1 rounded">
        <h5 class="font-semibold">
          Too High
        </h5>

        <div class="grid grid-cols-3 lg:grid-cols-5 gap-2">
          <div v-for="item, index in commonFoods(tooHigh)" :class="transparencyClass('accent-dark', index)"
            class="p-2 border border-dark rounded">
            <div class="truncate font-semibold text-sm">
              {{ item[0] }}
            </div>
            <div class="text-xs">
              {{ item[1] }} times
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>


<style lang="scss" scoped></style>