<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { computed } from "vue";
import EditGoal from "./Partials/EditGoal.vue";
import EditStats from "./Partials/EditStats.vue";
import EditTheme from "./Partials/EditTheme.vue";
import MenuButton from "@/Components/Menu/MenuButton.vue";

const props = defineProps(['status', 'account', 'calorieDays', 'carrots']);


const account = computed(() => props.account);



</script>

<template>

  <GlobalLayout head="Profile">

    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Profile</h2>
    </template>


    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <EditTheme :account="account" />

        <EditGoal :account="account" />

        <EditStats :account="account" />

      </div>
    </div>

    <template #aside>
      <div class="mx-4">
        <Link :href="route('profile.edit')" class="w-full">
        <MenuButton>
          Edit Account
        </MenuButton>
        </Link>
      </div>
    </template>

  </GlobalLayout>
</template>