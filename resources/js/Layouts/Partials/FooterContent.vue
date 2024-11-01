<script setup>
</script>

<template>
  <div class="grid sm:grid-cols-2 bg-dark min-h-64 py-14 font-bold text-xl text-light-text md:px-32">
    <div class="flex flex-col justify-around items-center sm:items-start ms-0 sm:ms-6 h-full">
      <div class="flex justify-between text-2xl w-1/2 md:w-1/3 mx-auto sm:mx-0">
        <Link :href="route('calculator')" class="mdi mdi-instagram hover:text-accent duration-300 ">
        </Link>
        <Link :href="route('calculator')" class="mdi mdi-youtube hover:text-accent duration-300">
        </Link>
        <Link :href="route('calculator')" class="mdi mdi-facebook hover:text-accent duration-300">
        </Link>
        <Link :href="route('calculator')" class="mdi mdi-dumbbell hover:text-accent duration-300">
        </Link>
      </div>
      <div>
        <p class="text-base mdi mdi-copyright"> CalorieCounter</p>
        <p class="text-xs text-neutral">ALL RIGHTS RESERVED
        </p>
      </div>
    </div>

    <div class="sm:hidden border-b border-neutral my-4 mx-4"></div>

    <div class="flex flex-col justify-around items-center sm:items-end me-0 sm:me-4">
      <Link :href="route('calculator')" class="text-base hover:text-accent duration-300 pe-2 pb-2 sm:pb-0">GET
      COUNTING!</Link>
      <ul class="text-sm text-neutral sm:space-y-1 flex flex-col items-start sm:items-end ">
        <li class="flex flex-wrap">
          <!-- <Link :href="route('calculator')" class="hover:text-white duration-300">
          Own a Crunch
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i> -->
          <Link :href="route('account.show')" class="hover:text-white duration-300">
          Contact
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
          <!-- <Link :href="route('calculator')" class="hover:text-white duration-300">
          Corporate Memberships
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i> -->
        </li>

        <li class="flex flex-wrap">
          <!-- <Link :href="route('calculator')" class="hover:text-white duration-300">
          Healthcare Partnerships
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
          <Link :href="route('calculator')" class="hover:text-white duration-300">
          Careers
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i> -->
          <Link :href="route('account.show')" class="hover:text-white duration-300">
          Terms of Use
          </Link>
          <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
        </li>

        <li class="flex flex-col sm:flex-row justify-end items-end space-y-1">
          <div class="flex">
            <Link :href="route('account.show')" class="hover:text-white duration-300">
            Privacy Policy
            </Link>
            <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
          </div>

          <div class="flex">
            <Link :href="route('account.show')" class="hover:text-white duration-300">
            Manage My Preferences
            </Link>
            <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
          </div>
        </li>
      </ul>
    </div>

  </div>
</template>
