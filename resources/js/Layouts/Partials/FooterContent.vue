<script setup>
import ShareButton from "@/Components/Nav/ShareButton.vue";


</script>

<template>
  <div class="grid grid-cols-2 bg-dark min-h-64 py-14 font-bold text-xl text-light-text md:px-32">
    <div class="flex flex-col justify-around items-center sm:items-start ms-0 sm:ms-6 h-full">
      <div class="flex justify-between text-2xl w-1/2 lg:w-1/4 mx-auto sm:mx-0">
        <ShareButton />
        <Link :href="route('calculator')" class="mdi mdi-calculator hover:text-accent-light duration-300">
        </Link>
        <Link :href="route('account.index')" class="mdi mdi-account-circle hover:text-accent-light duration-300">
        </Link>
        <Link :href="route('foodItem.index')" class="mdi mdi-food-apple hover:text-accent-light duration-300">
        </Link>
      </div>
      <div>
        <p class="text-base mdi mdi-copyright"> CalorieCounter</p>
        <p class="text-xs text-neutral-text">ALL RIGHTS RESERVED
        </p>
      </div>
    </div>

    <!-- <div class="sm:hidden border-b border-neutral my-4 mx-4"></div> -->

    <div class="flex flex-col justify-around items-start lg:items-end ms-4 lg:ms-0 me-0 lg:me-4">
      <Link :href="route('calculator')" class="text-base hover:text-accent-light duration-300 pe-2 pb-2 lg:pb-0">GET
      COUNTING!</Link>


      <!-- <ul class="text-sm text-neutral-text lg:space-y-1 flex flex-col items-start lg:items-end ">
        <li class="flex flex-wrap">

          <Link :href="route('account.index')" class="hover:text-light-text duration-300">
          Contact
          </Link>
          <i class="mdi mdi-circle-medium px-1 lg:px-2"></i>

        </li>

        <li class="flex flex-wrap">

          <Link :href="route('account.index')" class="hover:text-light-text duration-300">
          Terms of Use
          </Link>
          <i class="mdi mdi-circle-medium px-1 lg:px-2"></i>
        </li>

        <li class="flex flex-col lg:flex-row justify-end items-start lg:items-end space-y-1">
          <div class="flex">

            <Link :href="route('account.index')" class="hover:text-light-text duration-300">
            Privacy Policy
            </Link>
            <i class="mdi mdi-circle-medium px-1 lg:px-2"></i>
          </div>

          <div class="flex">
            <Link :href="route('account.index')" class="hover:text-light-text duration-300">
            Manage My Preferences
            </Link>
            <i class="mdi mdi-circle-medium px-1 lg:px-2"></i>
          </div>
        </li>
      </ul> -->
    </div>

  </div>
</template>
