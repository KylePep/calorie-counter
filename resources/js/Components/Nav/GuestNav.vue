<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import NavLink from "./NavLink.vue";
import ResponsiveNavLink from "./ResponsiveNavLink.vue";
import ApplicationLogo from "../ApplicationLogo.vue";

const props = defineProps(['canLogin', 'canRegister']);

const showingNavigationDropdown = ref(false);

const isAtTop = ref(true);

const handleScroll = () => {
  isAtTop.value = Math.round(window.scrollY == 0);
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
});

</script>


<template>

  <nav class="duration-1000"
    :class="[showingNavigationDropdown ? 'bg-dark py-2' : isAtTop ? 'bg-gradient-to-b from-dark/100 via-dark/50 to-transparent py-4 sm:py-8' : 'bg-dark py-2']">
    <!-- Primary Navigation Menu -->
    <div class="flex justify-between h-16 mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Logo -->
      <div class="flex w-full -my-2">
        <Link class="inline-flex items-center px-1 py-1" :href="route('welcome')" :active="route().current('welcome')">
        <ApplicationLogo class="duration-1000"
          :class="[showingNavigationDropdown ? 'text-5xl' : isAtTop ? 'text-6xl sm:text-7xl' : 'text-5xl']" />
        </Link>
      </div>

      <!-- Navigation Links -->
      <div class="hidden space-x-8 sm:-my-2 sm:flex me-4">
        <NavLink :href="route('calculator')" :active="route().current('calculator')">
          Calculator
        </NavLink>
      </div>

      <div class="hidden space-x-8 sm:ms-10 sm:flex duration-1000"
        :class="[showingNavigationDropdown ? 'sm:-my-2' : isAtTop ? 'sm:-my-0' : 'sm:-my-2']">
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
          Log In
        </ResponsiveNavLink>
        <ResponsiveNavLink :href="route('register')" :active="route().current('register')">
          Register
        </ResponsiveNavLink>
        <ResponsiveNavLink :href="route('calculator')" :active="route().current('calculator')">
          Calculator
        </ResponsiveNavLink>
      </div>

    </div>
  </nav>

</template>