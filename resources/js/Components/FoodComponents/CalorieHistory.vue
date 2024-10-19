<template>

  <div class="space-y-4 ">
    <!-- <h3 class="mb-4 text-2xl font-bold">Calorie Day History</h3> -->
    <div v-for="(day, index) in calorieDays" :key="index"
      class="flex flex-col min-h-40 min-w-40 bg-white p-4 text-center border-2 rounded-lg border-gray-300 shadow-lg">

      <div class="flex flex-1 flex-col justify-between space-y-3">

        <div class=" grid grid-cols-2 sm:grid-cols-4 gap-y-3">
          <p class="order-1 font-bold text-lg">{{ getDayOfWeek(new Date(day.created_at).getDay()) }}, {{ new
            Date(day.created_at).toLocaleDateString() }}</p>
          <h2 class="order-3 sm:order-2 text-lg">Calories: {{ day.count }}</h2>
          <h3 class="order-4 sm:order-3  text-lg">Goal: {{ day.goal }}</h3>
          <div class="order-2 sm:order-4 flex justify-center items-center">
            <Link :href="route('calorieDay.show', day)"
              class="ps-3 pe-2 py-0.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg"> Edit <i
              class="ms-2 mdi mdi-pencil"></i> </Link>
          </div>
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
          <h3 v-if="day.food_items.length != 0" class="font-bold">Food Eaten</h3>
          <p v-for="item in day.food_items" class="inline-block bg-gray-300 rounded-lg px-2 mx-1 lowercase text-sm">
            {{ item.description }} - {{ item.count }}
          </p>
        </div>
      </div>
    </div>

  </div>

</template>


<script>
import { Link } from "@inertiajs/vue3";
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