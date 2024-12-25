<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps(['account']);

const form = useForm(props.account ?? { peanut: 'butter' });

const showThemes = ref(false);
const newTheme = ref('');

function selectTheme(theme) {
  newTheme.value = theme;
  document.body.setAttribute('body-theme', theme);
}

function changeTheme(theme) {

  showThemes.value = false

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

function cancel() {
  showThemes.value = !showThemes.value;
  newTheme.value = '';
  document.body.setAttribute('body-theme', props.account.theme);
}

const themeDisplayName = computed(() => {
  const themeToDisplay = newTheme.value ? newTheme.value : props.account.theme;
  const rawTheme = themeToDisplay;
  return rawTheme
    .replace(/^theme-/, '')
    .replace(/([a-z])([A-Z])/g, '$1 $2')
    .replace(/(^[a-z])/g, match => match.toUpperCase());
});

</script>


<template>
  <div v-if="account?.id" class="p-4 lg:p-8 space-y-4">
    <div class="grid grid-cols-5 bg-light rounded p-1">
      <h1 class="font-bold col-span-4 flex items-center ms-1">
        Active Theme: {{ themeDisplayName }}
      </h1>


      <div class="flex justify-end">
        <PrimaryButton v-if="!showThemes" @click="showThemes = !showThemes"
          class="relative lg:block h-8 w-8 lg:h-min lg:w-full">
          <span class="hidden lg:block">Change Theme</span>
          <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-pencil"></span>
        </PrimaryButton>

        <SecondaryButton v-else @click="showThemes = false" class="relative lg:block h-8 w-8 lg:h-fit lg:w-fit">
          <span class="hidden lg:block">Cancel</span>
          <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-close-thick"></span>
        </SecondaryButton>
      </div>
    </div>

    <form v-if="showThemes" @submit.prevent="" class="my-3 space-y-3">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
        <button @click="selectTheme('theme-sunRise')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-sunRise' ? 'bg-[#f6a327] text-neutral-text' : 'bg-[#eb5e28] text-black'">
          Sun Rise
        </button>
        <button @click="selectTheme('theme-coolTides')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-coolTides' ? 'bg-[#a8dadc] text-neutral-text' : 'bg-[#457b9d] text-black'">
          Cool Tides
        </button>
        <!-- <button @click="changeTheme('theme-sketchPad')"
          class="p-3 font-bold hover:bg-dark hover:text-light-text rounded shadow-lg"
          :class="account.theme == 'theme-sketchPad' ? 'bg-[#2F7ED4] text-neutral-text' : 'bg-[#428AD8] text-black'">
          Sketch Pad
        </button> -->
      </div>
      <PrimaryButton @click="changeTheme(newTheme)">Save</PrimaryButton>
    </form>
  </div>

</template>