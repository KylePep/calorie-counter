<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieCount from "./partial/CalorieCount.vue";
import CalorieSchedule from "./partial/CalorieSchedule.vue";
import ConsumedReport from "./partial/ConsumedReport.vue";
import { computed, ref } from "vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import FoodRecommendations from "./partial/FoodRecommendations.vue";
import EditCarrot from "./partial/EditCarrot.vue";
import EditMacros from "./partial/EditMacros.vue";
import DashboardCard from "./partial/DashboardCard.vue";

const props = defineProps(['account', 'carrots', 'calorieDay', 'calorieDays', 'foodItems', 'foodRecommendations']);

const editCalorieSchedule = ref(false);

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



    <div class="relative space-y-4">

      <CalorieCount v-if="!editCalorieSchedule" :account :calorieDay />

      <CalorieSchedule v-if="account && editCalorieSchedule" :account :foodItems :calorieDay />

      <div v-if="account && calorieDay" class="absolute top-0 right-0">

        <PrimaryButton v-if="!editCalorieSchedule" aria-label="toggle calorie schedule"
          @click="editCalorieSchedule = true"
          class="relative lg:block h-8 w-8 lg:h-fit lg:w-fit mx-5 my-0.5 lg:mx-9 lg:-my-3.5">
          <span class="hidden lg:block">Set Calorie Schedule</span>
          <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-calendar"></span>
        </PrimaryButton>

        <SecondaryButton v-else @click="editCalorieSchedule = false"
          class="relative lg:block h-8 w-8 lg:h-fit lg:w-fit mx-5 my-0.5 lg:mx-9 lg:-my-3.5">
          <span class="hidden lg:block">Cancel</span>
          <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-close-thick"></span>
        </SecondaryButton>
      </div>

    </div>

    <div class="space-y-4">
      <EditMacros :account />
      <EditCarrot :account :carrots />

      <FoodRecommendations v-if="account" :account :foodRecommendations />

      <ConsumedReport v-if="account" :account :calorieDays />

    </div>

    <template #aside v-if="props.account">
      <DashboardCard :account :calorieDays :carrots />
    </template>

  </GlobalLayout>
</template>