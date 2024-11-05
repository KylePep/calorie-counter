<script setup>
import NavLink from "@/Components/Nav/NavLink.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { computed } from "vue";
import EditGoal from "./Partials/EditGoal.vue";
import EditStats from "./Partials/EditStats.vue";
import EditCarrot from "./Partials/EditCarrot.vue";

const props = defineProps(['status', 'account', 'calorieDays', 'carrots']);

const account = computed(() => props.account);

function changeTheme(theme) {
  document.body.classList.remove('theme-light', 'theme-dark');
  document.body.classList.add(`theme-${theme}`);
}

</script>

<template>

  <GlobalLayout head="Profile">
    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Profile</h2>
      <NavLink :href="route('profile.edit')">
        Edit Account
      </NavLink>
    </template>


    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="space-x-3">
          <button @click="changeTheme('light')">
            Light
          </button>
          <button @click="changeTheme('dark')">
            Dark
          </button>
          <button @click="changeTheme('banana')">
            Banana
          </button>
        </div>

        <EditGoal :account="account" />

        <EditCarrot :account="account" :carrots="carrots" />

        <EditStats :account="account" />

      </div>
    </div>
  </GlobalLayout>
</template>