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
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">History</h2>
    </template>

    <div class="space-y-12 max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

      <section v-if="props.account">
        <CalorieHistory :calorieDays="calorieDays" />
      </section>

    </div>

  </GlobalLayout>
</template>


<style lang="scss" scoped></style>