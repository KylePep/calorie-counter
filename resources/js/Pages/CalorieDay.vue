<script setup>
import CarrotDisplay from "@/Components/Displays/CarrotDisplay.vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import JournalEntry from "@/Components/Displays/JournalEntry.vue";
import Side from "@/Components/Displays/Side.vue";
import CalorieDayLayout from "@/Layouts/CalorieDayLayout.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CalorieKey from "@/Components/Displays/CalorieKey.vue";
import WeighInEntry from "@/Components/Displays/WeighInEntry.vue";

const props = defineProps(['account', 'calorieDay', 'with_fdcId', 'without_fdcId', 'carrots', 'weighIn']);

const calorieDay = ref(props.calorieDay)
const goal = computed(() => calorieDay.value?.goal);
const bmr = computed(() => calorieDay.value?.bmr);
const calorieCount = computed(() => calorieDay.value?.count ?? 0);

const getDayOfWeek = (date) => {
  const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  return daysOfWeek[date];
};

</script>


<template>

  <Head title="Calorie Day">
    <meta type="description" content="Edit a Calorie Day" head-key="CalorieDay">
  </Head>

  <GlobalLayout>

    <template #header>
      <h2 v-if="props.account" class="font-semibold text-xl leading-tight">Calorie Day</h2>
    </template>

    <CalorieDayLayout :account="account" :calorie-day="calorieDay" :with_fdc-id="with_fdcId"
      :without_fdc-id="without_fdcId" :carrots="carrots">
      <p class="col-span-3 sm:col-span-1">
        {{ getDayOfWeek(new Date(calorieDay.created_at).getDay()) }}, {{ new
          Date(calorieDay.created_at).toLocaleDateString() }}
      </p>
      <p>
        calories:
        {{ calorieCount }}
      </p>
      <p>
        Goal:
        {{ goal }}
      </p>
      <p>
        BMR:
        {{ bmr }}
      </p>

    </CalorieDayLayout>

    <template #leftSide>
      <Side side="left" v-if="props.account">
        <CalorieKey />
      </Side>
    </template>

    <template #rightSide>
      <Side v-if="props.account" side="right">
        <WeighInEntry :weighIn="weighIn" :date="calorieDay.created_at" />
        <JournalEntry :calorieDay="calorieDay" />
        <CarrotDisplay :carrots="carrots" />
      </Side>
      <Side v-if="props.account" side="right" class="hidden sm:block">
        <CreateFood />
      </Side>
    </template>

  </GlobalLayout>

</template>