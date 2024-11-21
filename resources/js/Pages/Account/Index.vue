<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { computed } from "vue";
import EditGoal from "./Partials/EditGoal.vue";
import EditStats from "./Partials/EditStats.vue";
import EditCarrot from "./Partials/EditCarrot.vue";
import EditTheme from "./Partials/EditTheme.vue";
import EditMacros from "./Partials/EditMacros.vue";
import Side from "@/Components/Displays/Side.vue";
import MenuButton from "@/Components/Menu/MenuButton.vue";

const props = defineProps(['status', 'account', 'calorieDays', 'carrots']);


const account = computed(() => props.account);



</script>

<template>

  <GlobalLayout head="Account">

    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Profile</h2>
    </template>


    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <EditTheme :account="account" />

        <EditGoal :account="account" />

        <EditMacros :account="account" />

        <EditStats :account="account" />

        <EditCarrot :account="account" :carrots="carrots" />

      </div>
    </div>

    <template #rightSide>
      <Link :href="route('profile.edit')" class="w-full">
      <MenuButton>
        Edit Account
      </MenuButton>
      </Link>
    </template>

  </GlobalLayout>
</template>