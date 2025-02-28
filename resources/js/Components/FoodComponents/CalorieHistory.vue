<script setup>
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "../Form/PrimaryButton.vue";

const props = defineProps(['timeZone', 'calorieDay', 'displayMode', 'index']);

const getDayOfWeek = (date) => {
  const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  return daysOfWeek[date];
};

const formattedDate = () => {
  return new Date(props.calorieDay.created_at).toLocaleDateString(props.timeZone, {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit'
  });
};

</script>

<template>

  <div v-if="displayMode == 'list'" :class="index % 2 == 0 ? 'border-accent/50' : 'border-light'"
    class="flex flex-col min-h-40 min-w-40 p-4 border-4 rounded  bg-white shadow-lg my-4">

    <div class="flex flex-1 flex-col justify-between space-y-3">

      <div class="text-sm sm:text-base grid grid-cols-2 sm:grid-cols-4 gap-y-3">
        <p class="order-1 font-bold">{{ getDayOfWeek(new Date(calorieDay.created_at).getDay()) }},
          <br class="hidden sm:block"> {{
            formattedDate() }}
        </p>
        <div class="order-3 sm:order-2 col-span-2 flex flex-col">
          <h2 class="text-center">Calories: {{ calorieDay.count }}</h2>
          <div class="flex justify-center space-x-2">
            <h3>Goal: {{ calorieDay.goal }}</h3>
            <h4>BMR: {{ calorieDay.bmr }}</h4>
          </div>
        </div>
        <div class="order-2 sm:order-3 flex justify-end items-center">
          <Link :href="route('calorieDay.show', calorieDay)">
          <PrimaryButton>Edit <i class="ms-2 mdi mdi-pencil"></i></PrimaryButton>
          </Link>
        </div>
      </div>

      <div>
        <h2 class="font-bold text-dark-text">
          Calorie Progress
        </h2>

        <!-- Progress bar container -->
        <div class="relative bg-white ring-offset-0 ring-2 ring-light/50 h-4 rounded shadow">

          <!-- Base progress bar (normal progress) -->
          <div class="bg-accent border-e border-light h-4 absolute top-0 left-0"
            :style="{ width: `${Math.min((calorieDay.count / calorieDay.bmr) * 100, 100)}%` }"
            title="calories compared to bmr">
          </div>

          <!-- Goal range bar -->
          <div class="bg-accent-light/50 border-s border-accent-dark h-4 absolute top-0 right-0"
            :style="{ width: `${100 - ((calorieDay.goal / calorieDay.bmr) * 100)}%` }" title="goal range">
          </div>

          <!-- Excess progress bar (only visible when calorieDay.count exceeds calorieDay.bmr) -->
          <div v-if="calorieDay.count > calorieDay.bmr" class="bg-special h-4 absolute top-0 left-0"
            :style="{ width: `${Math.min(((calorieDay.count - calorieDay.bmr) / 2000) * 100, 100)}%` }"
            title="calories in excess of bmr">
          </div>

        </div>
      </div>

      <div v-if="calorieDay.food_items.length != 0">
        <h3 class="font-bold text-dark-text">
          Food Eaten</h3>
        <div class="bg-white border border-2 border-light/50 p-0.5 pb-1 rounded">
          <p v-for="item, index in calorieDay.food_items" :key="index"
            class="inline-block bg-light/20  rounded px-1 mx-1 lowercase text-sm text-dark-text">
            {{ item.description }} - {{ item.count }}
          </p>
        </div>
      </div>

      <div v-if="calorieDay.journal">
        <h4 class="font-bold text-dark-text">Journal</h4>
        <div class="bg-white rounded border border-2 border-light/50 p-1">
          {{ calorieDay.journal }}
        </div>
      </div>
    </div>
  </div>

  <div v-else class="grid grid-cols-5 border-b  border-neutral/75 ps-2"
    :class="index % 2 == 0 ? 'bg-accent-light/40' : 'bg-main/40'">
    <div class="col-span-2 sm:col-span-1 flex items-center text-xs ">
      <p class="text-sm tabular-nums leading-tight"> {{ formattedDate() }}
      </p>
      <Link :href="route('calorieDay.show', calorieDay)"
        class=" mx-auto px-1 rounded-sm hover:bg-neutral hover:text-light-text duration-300">
      edit
      </Link>
    </div>
    <!-- Progress bar container -->
    <div class="relative col-span-3 sm:col-span-4 bg-white border border-4 border-light h-5 rounded shadow">

      <!-- Base progress bar (normal progress) -->
      <div class="bg-accent border-e border-light h-3 absolute top-0 left-0"
        :style="{ width: `${Math.min((calorieDay.count / calorieDay.bmr) * 100, 100)}%` }"
        title="calories compared to bmr">
      </div>

      <!-- Goal range bar -->
      <div class="bg-accent-light/50 border-s border-accent-dark h-3 absolute top-0 right-0"
        :style="{ width: `${100 - ((calorieDay.goal / calorieDay.bmr) * 100)}%` }" title="goal range">
      </div>

      <!-- Excess progress bar (only visible when calorieDay.count exceeds calorieDay.bmr) -->
      <div v-if="calorieDay.count > calorieDay.bmr" class="bg-special h-3 absolute top-0 left-0"
        :style="{ width: `${Math.min(((calorieDay.count - calorieDay.bmr) / 2000) * 100, 100)}%` }"
        title="calories in excess of bmr">
      </div>

    </div>
  </div>

</template>
