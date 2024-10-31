<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "../Components/FoodComponents/CalorieHistory.vue";
import { Head } from "@inertiajs/vue3";

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

    <section v-if="props.account" class="min-h-screen">
      <CalorieHistory :calorieDays="calorieDays" />
    </section>

  </GlobalLayout>
</template>