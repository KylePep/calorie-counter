<script setup>
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(['account']);

const form = useForm(props.account ?? { peanut: 'butter' });

function changeTheme(theme) {

  form.transform((data) => ({
    ...data,
    theme: theme
  })).put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success('Theme set!')
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

  document.body.setAttribute('body-theme', theme);

}

</script>


<template>
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Select a theme:
    </h1>

    <form @submit.prevent="" class="my-3">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
        <button @click="changeTheme('theme-sunRise')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-sunRise' ? 'bg-[#f6a327] text-neutral-text' : 'bg-[#eb5e28] text-black'">
          Sun Rise
        </button>
        <button @click="changeTheme('theme-coolTides')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-coolTides' ? 'bg-[#a8dadc] text-neutral-text' : 'bg-[#457b9d] text-black'">
          Cool Tides
        </button>
        <button @click="changeTheme('theme-sketchPad')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-sketchPad' ? 'bg-[#2F7ED4] text-neutral-text' : 'bg-[#428AD8] text-black'">
          Sketch Pad
        </button>
      </div>
    </form>
  </div>

</template>