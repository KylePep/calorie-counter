<script setup>
import CarrotDisplay from "@/Components/CarrotDisplay.vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import JournalEntry from "@/Components/JournalEntry.vue";
import Side from "@/Components/Side.vue";
import CalorieDayLayout from "@/Layouts/CalorieDayLayout.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps(['account', 'calorieDay', 'with_fdcId', 'without_fdcId', 'carrots']);

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

  <Head title="Dashboard">
    <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
  </Head>

  <GlobalLayout>

    <template #header>
      <h2 v-if="props.account" class="font-semibold text-xl leading-tight">Calorie Day</h2>
    </template>

    <CalorieDayLayout :account="account" :calorie-day="calorieDay" :with_fdc-id="with_fdcId"
      :without_fdc-id="without_fdcId" :carrots="carrots">
      <p>{{ getDayOfWeek(new Date(calorieDay.created_at).getDay()) }}, {{ new
        Date(calorieDay.created_at).toLocaleDateString() }}</p>
      <p class="text-xl font-bold mt-2">
        calories: {{ calorieCount }}
      </p>
      <p class="text-lg">Goal: {{ goal }}, BMR: {{ bmr }}.
      </p>
    </CalorieDayLayout>

    <template #leftSide>
      <Side side="left" class="hidden lg:block" v-if="props.account">
        <CreateFood />

      </Side>
    </template>

    <template #rightSide>
      <Side v-if="props.account" side="right" class="">
        <JournalEntry :calorieDay="calorieDay" />
        <CarrotDisplay :carrots="carrots" />
      </Side>
    </template>

  </GlobalLayout>

</template>


<style lang="scss" scoped></style>