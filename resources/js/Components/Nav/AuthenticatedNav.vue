<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Form/Dropdown.vue';
import DropdownLink from '@/Components/Form/DropdownLink.vue';
import NavLink from '@/Components/Nav/NavLink.vue';
import ResponsiveNavLink from '@/Components/Nav/ResponsiveNavLink.vue';
import ShareButton from "./ShareButton.vue";

const props = defineProps(['account']);

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
    <nav class="duration-1000 "
        :class="[showingNavigationDropdown ? 'bg-dark py-2' : isAtTop ? 'bg-gradient-to-b from-dark/100 via-dark/50 to-transparent py-4 sm:py-8' : 'bg-dark py-2']">

        <!-- Primary Navigation Menu -->
        <div class="flex justify-between h-16 mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex w-full -my-2">
                <Link class="inline-flex items-center p-2" :href="route('welcome')"
                    :active="route().current('welcome')">
                <ApplicationLogo class=" duration-1000" />
                </Link>
            </div>

            <NavLink :href="route('calorieDay.index')" :active="route().current('calorieDay.index')"
                class="sm:hidden text-sm -my-2 me-4">
                Count
            </NavLink>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-2 sm:ms-10 sm:flex duration-1000"
                :class="[showingNavigationDropdown ? 'sm:-my-2' : isAtTop ? 'sm:-my-0' : 'sm:-my-2']">

                <NavLink :href="route('calorieDay.index')" :active="route().current('calorieDay.index')">
                    Count
                </NavLink>
                <NavLink :href="route('calculator')" :active="route().current('calculator')">
                    Calculator
                </NavLink>
                <NavLink v-if="$page.props.auth.account" :href="route('foodItem.index')"
                    :active="route().current('foodItem.index')">
                    Food
                </NavLink>
                <NavLink v-if="$page.props.auth.account" :href="route('history')" :active="route().current('history')">
                    History
                </NavLink>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button aria-label="nav drop down" type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-light-text bg-dark hover:text-accent focus:outline-none transition ease-in-out duration-150">
                                    {{ $page.props.auth.user.name }}

                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="flex flex-col p-2 bg-dark rounded">
                                <DropdownLink :href="route('account.index')"> Profile </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button aria-label="nav drop down" @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="inline-flex items-center justify-center p-2 rounded-md text-light-text hover:text-dark-text hover:bg-accent focus:outline-none focus:bg-accent focus:text-dark-text transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{
                            hidden: showingNavigationDropdown,
                            'inline-flex': !showingNavigationDropdown,
                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
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
                <ResponsiveNavLink :href="route('calculator')" :active="route().current('calculator')">
                    Calculator
                </ResponsiveNavLink>
                <ResponsiveNavLink v-if="$page.props.auth.account" :href="route('foodItem.index')"
                    :active="route().current('foodItem.index')">
                    Food
                </ResponsiveNavLink>
                <ResponsiveNavLink v-if="$page.props.auth.account" :href="route('history')"
                    :active="route().current('history')">
                    History
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div class="relative pt-4 pb-1 border-t border-gray-200">
                <div class="absolute top-0 right-0  text-light-text text-lg px-3 mt-2">
                    <ShareButton />
                </div>

                <div class="mt-4 space-y-1">
                    <ResponsiveNavLink :href="route('account.index')"> Profile - {{ $page.props.auth.user.name }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>

</template>
