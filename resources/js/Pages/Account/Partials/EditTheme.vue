<script setup>
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(['account']);

const form = useForm(props.account);

function changeTheme(theme) {

  form.theme = theme;

  form.put(route('account.update', props.account.id), {
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
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Select a theme:
    </h1>

    <form @submit.prevent="" class="my-3">
      <div class="space-x-3">
        <button @click="changeTheme('theme-sunRise')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-light' ? 'bg-[#f6a327] text-neutral-text' : 'bg-[#eb5e28] text-dark-text'">
          Sun Rise
        </button>
        <button @click="changeTheme('theme-coolTides')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-dark' ? 'bg-[#a8dadc] text-neutral-text' : 'bg-[#457b9d] text-dark-text'">
          Cool Tides
        </button>
        <button @click="changeTheme('theme-sketchPad')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-dark' ? 'bg-[#2F7ED4] text-neutral-text' : 'bg-[#428AD8] text-dark-text'">
          Sketch Pad
        </button>
      </div>
    </form>
  </div>

</template>