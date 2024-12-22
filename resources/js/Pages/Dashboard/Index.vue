<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieCount from "./partial/CalorieCount.vue";
import CalorieSchedule from "./partial/CalorieSchedule.vue";
import ConsumedReport from "./partial/ConsumedReport.vue";
import { computed } from "vue";

const props = defineProps(['account', 'calorieDay', 'calorieDays', 'foodItems']);

const renderHeroImage = computed(() => {
  if (props.account) {
    return null
  } else {
    return '/assets/dashboardNoAccount.webp'
  }
});

</script>

<template>
  <GlobalLayout head="Dashboard" :heroImage="renderHeroImage" heroHeight="20">

    <template #header>
      <h2 v-if="props.account">Dashboard</h2>
      <h2 v-else>
        <Link :href="route('calculator')" class="text-accent-light hover:text-white hover:animate-none duration-300">
        Set a Goal <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i>
        </Link>
      </h2>
    </template>

    <div class="space-y-32 my-16">

      <CalorieCount :account :calorieDay />

      <CalorieSchedule v-if="account" :account :foodItems />

      <ConsumedReport v-if="account" :account :calorieDays />

    </div>

  </GlobalLayout>
</template>