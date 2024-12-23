<script setup>
import CalorieDisplay from "@/Components/FoodComponents/CalorieDisplay.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import NoAccountCard from "@/Components/NoAccountCard.vue";
import { Link } from "@inertiajs/vue3";



const props = defineProps(['account', 'calorieDay']);
</script>


<template>
  <div v-if="account && calorieDay" class="text-neutral-text p-4 lg:p-8">
    <h1 class="text-2xl font-bold  mb-3">
      Today's calorie counter
    </h1>
    <div
      class="grid grid-cols-3 xl:grid-cols-4 font-bold text-xs xl:text-base text-neutral-text text-center bg-main border border-light border-b-0 rounded-t px-1 sm:px-3 py-1 uppercase">
      <p class="col-span-3 xl:col-span-1">
        Today: {{ new Date().toLocaleDateString() }}
      </p>
      <p>
        calories:
        {{ props.calorieDay.count }}
      </p>
      <p>
        Goal:
        {{ props.account.goal }}
      </p>
      <p>
        BMR:
        {{ props.calorieDay.bmr }}
      </p>
    </div>
    <Link :href="route('calorieDay.index')" class="w-full">
    <CalorieDisplay v-if="props.account" :goal="props.account.goal" :calorieCount="props.calorieDay.count"
      :bmr="props.calorieDay.bmr" />
    </Link>
  </div>

  <div v-else class="text-neutral-text p-4 lg:p-8 space-y-8">
    <h1 class="text-2xl font-bold  mb-3">
      Calorie Counter
    </h1>

    <div>No counter today, yet.</div>

    <div>
      <Link :href="route('calorieDay.index')">
      <PrimaryButton>Start Today's Count</PrimaryButton>
      </Link>
    </div>

  </div>

  <div v-if="!account">
    <NoAccountCard />
  </div>


</template>
