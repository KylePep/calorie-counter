<script setup>
import JournalEntry from "@/Components/Displays/JournalEntry.vue";
import Side from "@/Components/Displays/Side.vue";
import CalorieDayLayout from "@/Layouts/CalorieDayLayout.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import WeighInEntry from "@/Components/Displays/WeighInEntry.vue";
import MenuArray from "@/Components/Menu/MenuArray.vue";

const props = defineProps(['account', 'calorieDay', 'weighIn', 'foodItems']);

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
      <h2 v-if="props.account" class="font-semibold text-xl leading-tight">Calorie Counter - {{ getDayOfWeek(new
        Date(calorieDay.created_at).getDay()) }}, {{ new
          Date(calorieDay.created_at).toLocaleDateString() }}</h2>
    </template>

    <CalorieDayLayout :account="account" :calorieDay :foodItems :carrots>

      {{ getDayOfWeek(new Date(calorieDay.created_at).getDay()) }}, {{ new
        Date(calorieDay.created_at).toLocaleDateString() }}

    </CalorieDayLayout>

    <template #leftSide></template>

    <template #rightSide>
      <Side v-if="props.account" side="right" class="hidden lg:block">
        <WeighInEntry :weighIn="weighIn" :date="new Date(calorieDay.created_at)" />
        <JournalEntry :calorieDay="calorieDay" />
        <MenuArray :account :weighIn :calorieDay :foodItems />
      </Side>
    </template>

  </GlobalLayout>

</template>