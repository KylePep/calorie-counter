<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieCount from "./partial/CalorieCount.vue";
import CalorieSchedule from "./partial/CalorieSchedule.vue";
import ConsumedReport from "./partial/ConsumedReport.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);
</script>

<template>
  <GlobalLayout head="Dashboard">

    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Dashboard</h2>
    </template>

    <div class="space-y-32">

      <div>
        <CalorieCount />
      </div>

      <div>
        <CalorieSchedule />
      </div>

      <div>
        <ConsumedReport />
      </div>

    </div>

  </GlobalLayout>
</template>