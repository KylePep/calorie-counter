<script setup>
import PrimaryButton from "../Form/PrimaryButton.vue";
</script>


<template>
  <div class="bg-light p-2 rounded">
    bar that you drag around to select calories

    <div class="w-full bg-dark h-6 relative mt-2 ring ring-dark ">

      <div class="bg-accent-light h-6 w-full absolute">
        <p class="absolute right-4 -top-2 my-2 text-dark-text font-bold">
          Breakfast
        </p>
      </div>

      <div class="bg-accent h-6 w-3/4 absolute">
        <p class="absolute right-4 -top-2 my-2 text-dark-text font-bold">
          Lunch
        </p>
        <div class="absolute bg-white border border-dark rounded-sm h-9 w-3 -top-2 right-0"></div>
      </div>

      <div class="bg-accent-dark h-6 w-1/2 absolute">
        <p class="absolute right-4 -top-2 my-2 text-white font-bold">
          Dinner
        </p>
        <div class="absolute bg-white border border-dark rounded-sm h-9 w-3 -top-2 right-0"></div>
      </div>

      <div class="bg-special h-6 w-1/4 absolute">
        <p class="absolute right-4 -top-2 my-2 text-white font-bold">
          Snack
        </p>
        <div class="absolute bg-white border border-dark rounded-sm h-9 w-3 -top-2 right-0"></div>
      </div>

    </div>

  </div>
  <div>
    <PrimaryButton>Set</PrimaryButton>
  </div>
</template>
