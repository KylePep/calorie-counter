<script setup></script>


<template>
  <div class="relative border-b-4 border-neutral w-48 mx-auto mb-10">
    <h2 class="absolute inset-x-0 -top-3 mx-8 text-center font-bold bg-main"> FEATURE #2
    </h2>
  </div>

  <h3 class="capitalize text-3xl font-bold mb-4">Create an account</h3>
  <div class="grid sm:grid-cols-3 gap-6">
    <div>
      <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
        <i class="absolute -left-4 top-0 mdi mdi-account-plus text-4xl text-accent-red  "></i>
        <i class="absolute left-6 top-8 mdi mdi-format-list-bulleted-type text-5xl text-accent"></i>
        <i class="absolute -bottom-4 -right-2 mdi mdi-login text-4xl text-accent-yellow group-hover:animate-pulse"></i>
      </div>
      <h4 class="font-bold text-4xl py-1">
        Sign up
      </h4>
      <p class="text-sm">Create a profile with the super simple registering process. This will give you access to 100%
        of CalorieCounter.</p>
    </div>
    <div>
      <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
        <i class="absolute -left-4 -bottom-4 mdi mdi-tape-measure text-5xl text-dark"></i>
        <i class="absolute left-4 top-2 mdi mdi-scale-balance text-6xl text-neutral group-hover:animate-bounce"></i>
        <i class="absolute -right-2 -bottom-4 mdi mdi-checkbox-marked-circle-plus-outline text-4xl text-light"></i>
      </div>
      <h4 class="font-bold text-4xl py-1">
        Goals
      </h4>
      <p class="text-sm">
        Take advantage of the BMR calculator using the Mifflin-St Jeor formula, or set your own
        calorie goal.
      </p>
    </div>
    <div>
      <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
        <i class="absolute -left-6 top-0 mdi mdi-scale text-4xl text-accent"></i>
        <i class="absolute -right-5 top-0 mdi mdi-food-fork-drink text-4xl text-accent-red"></i>
        <i class="absolute -bottom-8 left-8 mdi mdi-pencil-plus text-4xl text-accent-yellow"></i>
        <i class="absolute top-4 left-2 mdi mdi-robot-happy-outline text-7xl text-special group-hover:animate-spin"></i>
      </div>
      <h4 class="font-bold text-4xl py-1">
        Tracking
      </h4>
      <p class="text-sm">
        Search the USDA database for foods or create your own, then add them to your day to track
        your
        calories!
      </p>
    </div>
  </div>
</template>