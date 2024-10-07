<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "../Components/FoodComponents/CalorieHistory.vue";

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

  <Head title="Dashboard">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">History</h2>
    </template>

    <div class="space-y-12 max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

      <section v-if="props.account" class="text-center">
        <CalorieHistory :calorieDays="calorieDays" />
      </section>

    </div>

  </GlobalLayout>
</template>


<style lang="scss" scoped></style>