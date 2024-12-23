<script setup>
import { Link } from "@inertiajs/vue3";

</script>

<template>
  <div class="flex flex-col text-center justify-center items-center  py-8 px-4 space-y-4 rounded shadow-xl">
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
