<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import PageLayout from "./PageLayout.vue";
import GuestNav from "@/Components/GuestNav.vue";
import AuthenticatedNav from "@/Components/AuthenticatedNav.vue";
import CalculateBanner from '../Components/CalculateBanner.vue'

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  head: {
    type: String,
  },
  heroImage: {
    type: String
  }
})

const page = usePage();
</script>


<template>
  <div class="relative flex flex-col bg-page min-h-screen" style="scrollbar-gutter: stable;">
    <nav class="sticky top-0 z-20 shadow-xl">
      <GuestNav v-if="!$page.props.auth.user?.name" :canLogin="canLogin" :canRegister="canRegister" />
      <AuthenticatedNav v-else></AuthenticatedNav>
    </nav>

    <Head :title="$props.head" content="description required" :head-key="$props.head" />

    <header class="bg-neutral text-text-light shadow" v-if="$slots.header">

      <div v-if="heroImage" class="flex justify-center items-center  h-96 space-x-3 mx-auto py-6 px-4 sm:px-6 lg:px-8 "
        :style="{ backgroundImage: `linear-gradient(to top, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.4) 80%, rgba(0, 0, 0, 0.5) 100%), url(${heroImage})`, backgroundPosition: '50% 10%', backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }">
        <h2 class="font-semibold text-7xl leading-tight text-shadow-xl text-white">
          <slot name="header"></slot>
        </h2>

      </div>

      <div v-else class="flex justify-between space-x-3 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
      <CalculateBanner position="header" />

    </header>

    <main class="grid grid-cols-4 flex-1 mt-10">


      <div class="col-span-4 lg:col-span-1">
        <div v-if="$slots.leftSide" class="sticky top-16">
          <slot name="leftSide" />
        </div>
      </div>

      <PageLayout class="col-start-1 lg:col-start-2 col-span-4 lg:col-span-2">
        <slot />
      </PageLayout>

      <div class="col-span-4 lg:col-span-1  lg:col-start-4">
        <div v-if="$slots.rightSide" class="sticky top-16">
          <slot name="rightSide" />
        </div>
      </div>
    </main>

    <footer class="mt-20">
      <div v-if="!page.url.includes('dashboard')">
        <CalculateBanner position="footer" />
      </div>
      <div class="grid sm:grid-cols-2 bg-dark min-h-64 py-14 font-bold text-xl text-text-light sm:px-32">
        <div class="flex flex-col justify-around items-center sm:items-start ms-0 sm:ms-6 h-full">
          <div class="flex justify-between text-2xl w-1/2 sm:w-1/3 mx-auto sm:mx-0">
            <Link :href="route('calculator')" class="mdi mdi-instagram">
            </Link>
            <Link :href="route('calculator')" class="mdi mdi-youtube">
            </Link>
            <Link :href="route('calculator')" class="mdi mdi-facebook">
            </Link>
            <Link :href="route('calculator')" class="mdi mdi-dumbbell">
            </Link>
          </div>
          <div class="">
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
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Own a Crunch
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Contact
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Corporate Memberships
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
            </li>

            <li class="flex flex-wrap">
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Healthcare Partnerships
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Careers
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Terms of Use
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
            </li>

            <li class="flex flex-wrap">
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Privacy Policy
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
              <Link :href="route('calculator')" class="hover:text-white duration-300">
              Manage My Preferences
              </Link>
              <i class="mdi mdi-circle-medium px-1 sm:px-2"></i>
            </li>
          </ul>
        </div>

      </div>
    </footer>
  </div>


</template>


<style lang="scss" scoped></style>