<script setup>
import { ref } from "vue";
import ApplicationLogo from "./ApplicationLogo.vue";
import NavLink from "./NavLink.vue";
import DropdownLink from "./DropdownLink.vue";
import ResponsiveNavLink from "./ResponsiveNavLink.vue";
import Dropdown from "./Dropdown.vue";


defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  }
});

const showingNavigationDropdown = ref(false);

</script>


<template>

  <nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="shrink-0 flex items-center">
            <Link href="/">
            <ApplicationLogo class="block w-auto fill-current text-black/75 text-5xl" />
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

            <NavLink :href="route('calculator')" :active="route().current('calculator')">
              Calculator
            </NavLink>
          </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
          <!-- Settings Dropdown -->
          <NavLink :href="route('login')" :active="route().current('login')">
            Login
          </NavLink>
          <NavLink :href="route('register')" :active="route().current('register')">
            Register
          </NavLink>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
          <button @click="showingNavigationDropdown = !showingNavigationDropdown"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path :class="{
                hidden: showingNavigationDropdown,
                'inline-flex': !showingNavigationDropdown,
              }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{
                hidden: !showingNavigationDropdown,
                'inline-flex': showingNavigationDropdown,
              }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
          Log In
        </ResponsiveNavLink>
        <ResponsiveNavLink :href="route('register')" :active="route().current('register')">
          Register
        </ResponsiveNavLink>
        <ResponsiveNavLink :href="route('calculator')" :active="route().current('dashboard')">
          Calculator
        </ResponsiveNavLink>
      </div>

    </div>
  </nav>

</template>


<style lang="scss" scoped></style>