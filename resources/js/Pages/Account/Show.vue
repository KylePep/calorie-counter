<script setup>
import NavLink from "@/Components/Nav/NavLink.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { computed } from "vue";
import EditGoal from "./Partials/EditGoal.vue";
import EditStats from "./Partials/EditStats.vue";
import EditCarrot from "./Partials/EditCarrot.vue";
import { useForm } from "@inertiajs/vue3";
import Pop from "@/utils/Pop.js";

const props = defineProps(['status', 'account', 'calorieDays', 'carrots']);

const form = useForm(props.account);

const account = computed(() => props.account);

function changeTheme(theme) {

  form.theme = theme;

  form.put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success('Theme Set')
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

  document.body.setAttribute('body-theme', theme);

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

        <form @submit.prevent="">
          <div class="space-x-3">
            <button @click="changeTheme('theme-light')" class="p-3 rounded"
              :class="account.theme == 'theme-light' ? 'bg-[#f6a327] text-neutral-text' : 'bg-[#eb5e28] text-dark-text'">
              Sun Rise
            </button>
            <button @click="changeTheme('theme-dark')" class="p-3 rounded"
              :class="account.theme == 'theme-dark' ? 'bg-[#a8dadc] text-neutral-text' : 'bg-[#457b9d] text-dark-text'">
              Cool Tides
            </button>
          </div>
        </form>

        <EditGoal :account="account" />

        <EditCarrot :account="account" :carrots="carrots" />

        <EditStats :account="account" />

      </div>
    </div>
  </GlobalLayout>
</template>