<template>

  <div class="">
    <div v-for="(day, index) in calorieDays" :key="index"
      class="flex flex-col min-h-40 min-w-40 bg-white p-4 text-center border-4 rounded-lg border-black/25">

      <div class="flex flex-1 flex-col justify-between space-y-3">

        <div class=" grid grid-cols-3">
          <p class="font-bold text-lg">{{ getDayOfWeek(new Date(day.created_at).getDay()) }}, {{ new
            Date(day.created_at).toLocaleDateString() }}</p>
          <h2 class="text-lg">Calories: {{ day.count }}</h2>
          <h3 class="text-lg">Goal: {{ day.goal }}</h3>
        </div>
        <h2 class="font-bold">Calorie Progress</h2>
        <!-- Progress bar container -->
        <div class="relative border border-4 border-black/25 h-5 rounded">

          <!-- Base progress bar (normal progress) -->
          <div class="bg-gray-500 h-3 absolute top-0 left-0"
            :style="{ width: `${Math.min((day.count / day.goal) * 100, 100)}%` }" title="calories compared to goal">
          </div>

          <!-- Excess progress bar (only visible when day.count exceeds day.goal) -->
          <div v-if="day.count > day.goal" class="bg-gray-300 h-3 absolute top-0 left-0"
            :style="{ width: `${Math.min(((day.count - day.goal) / 2000) * 100, 100)}%` }"
            title="calories in excess of goal"></div>
        </div>

        <div>
          <h3 class="font-bold">Food Eaten</h3>
          <p v-for="item in day.food_items" class="inline-block bg-gray-300 rounded-lg px-2 mx-1 lowercase text-sm">
            <template v-if="item.description">
              {{ item.description }} - {{ item.count }}
            </template>
            <!-- //TODO - Remove after data purification -->
            <template v-else>
              {{ item }}
            </template>
          </p>
        </div>
      </div>
    </div>

  </div>

</template>


<script>
import { computed } from "vue";
export default {
  props: ({
    calorieDays: {
      type: Object
    }
  }),
  setup(props) {

    const getDayOfWeek = (date) => {
      const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      return daysOfWeek[date];
    };

    return {
      calorieDays: computed(() => props.calorieDays),
      getDayOfWeek,

      dayItems(calorieDay) {
        if (calorieDay.food_items.length == 0) {
          return []
        } else {
          return calorieDay.food_items
            .split('"')
            .filter((item, index) => index % 2 !== 0 && item.trim());
        }
      },

    }
  }
}
</script>


<style lang="scss" scoped></style>