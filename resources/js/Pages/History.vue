<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "../Components/FoodComponents/CalorieHistory.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  account: {
    type: Object,
  },
  calorieDays: {
    type: Object
  }
});

</script>


<template>

  <Head title="History">
    <meta type="description" content="Calorie History" head-key="Food">
  </Head>

  <GlobalLayout>
    <template #header>
      <h2 class="font-semibold text-xl leading-tight">History</h2>
    </template>


    <section v-if="props.account">
      <CalorieHistory :calorieDays="calorieDays" />
    </section>


  </GlobalLayout>
</template>


<style lang="scss" scoped></style>