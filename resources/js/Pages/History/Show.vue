<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "@/Components/FoodComponents/CalorieHistory.vue";
import { Head } from "@inertiajs/vue3";
import NewDay from "./Partials/NewDay.vue";
import Side from "@/Components/Displays/Side.vue";

const props = defineProps(['account', 'calorieDays']);

</script>


<template>

  <Head title="History">
    <meta type="description" content="Calorie History" head-key="Food">
  </Head>

  <GlobalLayout heroImage="/assets/calorieHistory.jpeg" heroHeight="50">

    <template #header>
      Your History
    </template>

    <section v-if="props.account" class="sm:hidden">
      <NewDay />
    </section>

    <section v-if="props.account" class="min-h-screen">
      <CalorieHistory :calorieDays="calorieDays" />
    </section>

    <template #rightSide>
      <Side v-if="props.account" side="right">
        <NewDay />
      </Side>
    </template>

  </GlobalLayout>
</template>