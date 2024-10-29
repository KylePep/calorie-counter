<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import PrimaryButton from "../PrimaryButton.vue";

const props = defineProps(['calorieDays']);
const calorieDays = computed(() => props.calorieDays);

const getDayOfWeek = (date) => {
  const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  return daysOfWeek[date];
};

</script>

<template>

  <div class="space-y-4 ">
    <div v-for="(day, index) in calorieDays" :key="index"
      class="flex flex-col min-h-40 min-w-40 bg-white p-4 text-center border-2 rounded border-light bg-main shadow-lg">

      <div class="flex flex-1 flex-col justify-between space-y-3">

        <div class=" grid grid-cols-2 sm:grid-cols-4 gap-y-3">
          <p class="order-1 font-bold text-lg">{{ getDayOfWeek(new Date(day.created_at).getDay()) }}, {{ new
            Date(day.created_at).toLocaleDateString() }}</p>
          <h2 class="order-3 sm:order-2 text-lg">Calories: {{ day.count }}</h2>
          <h3 class="order-4 sm:order-3  text-lg">Goal: {{ day.goal }}</h3>
          <div class="order-2 sm:order-4 flex justify-center items-center">
            <Link :href="route('calorieDay.show', day)">
            <PrimaryButton>Edit <i class="ms-2 mdi mdi-pencil"></i></PrimaryButton>
            </Link>
          </div>
        </div>

        <h2 class="font-bold">Calorie Progress</h2>

        <!-- Progress bar container -->
        <div class="relative bg-light border border-4 border-black/25 h-5 rounded">

          <!-- Base progress bar (normal progress) -->
          <div class="bg-accent h-3 absolute top-0 left-0"
            :style="{ width: `${Math.min((day.count / day.goal) * 100, 100)}%` }" title="calories compared to goal">
          </div>

          <!-- Excess progress bar (only visible when day.count exceeds day.goal) -->
          <div v-if="day.count > day.goal" class="bg-special h-3 absolute top-0 left-0"
            :style="{ width: `${Math.min(((day.count - day.goal) / 2000) * 100, 100)}%` }"
            title="calories in excess of goal"></div>
        </div>

        <div>
          <h3 v-if="day.food_items.length != 0" class="font-bold">Food Eaten</h3>
          <p v-for="item in day.food_items"
            class="inline-block bg-light rounded-lg px-2 mx-1 lowercase text-sm text-dark">
            {{ item.description }} - {{ item.count }}
          </p>
        </div>

        <div>
          <h4 class="font-bold">Journal</h4>
          {{ day.journal }}
        </div>
      </div>
    </div>

  </div>

</template>
