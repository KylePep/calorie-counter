<script setup>
import NavLink from "@/Components/Nav/NavLink.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { computed } from "vue";
import EditGoal from "./Partials/EditGoal.vue";
import EditStats from "./Partials/EditStats.vue";
import EditCarrot from "./Partials/EditCarrot.vue";

const props = defineProps(['status', 'account', 'calorieDays', 'carrots']);

const account = computed(() => props.account);

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

        <EditGoal :account="account" />

        <EditCarrot :account="account" :carrots="carrots" />

        <EditStats :account="account" />

      </div>
    </div>
  </GlobalLayout>
</template>