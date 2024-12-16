<script setup>
import CalorieDisplay from "@/Components/FoodComponents/CalorieDisplay.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";


const props = defineProps(['account', 'calorieDay']);
</script>


<template>
  <div v-if="account" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Calorie Counter
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


  <div v-else class="flex flex-col text-center justify-center items-center  py-8 space-y-4 rounded shadow-xl">
    <p
      class="text-transparent text-5xl font-bold bg-gradient-to-r from-accent-dark via-accent to-accent-light bg-clip-text">
      Calorie Calculator</p>
    <p class="text-lg">Calorie Counter uses your goal and information entered in your account to help you track your
      calories.</p>
    <p class="text-lg pb-10">Please calculate your goal using the provided calculator or you can manually enter your
      goal
      on
      the profile
      page!</p>


    <Link :href="route('calculator')"
      class="text-white font-bold uppercase bg-gradient-to-r from-accent-dark via-accent to-accent-light w-1/2 py-4 duration-300 rounded-sm hover:ring ring-accent">
    get your bmr!
    </Link>

    <p>or</p>

    <Link :href="route('account.index')"
      class="text-white font-bold uppercase bg-gradient-to-r from-accent-dark via-accent to-accent-light w-1/2 py-4 duration-300 rounded-sm hover:ring ring-accent">
    enter goal
    </Link>
  </div>


</template>
