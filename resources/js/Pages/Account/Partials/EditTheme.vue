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
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12 space-y-4">
    <div class="grid grid-cols-5">
      <h1 class="font-bold mb-3 col-span-5 lg:col-span-3">
        Active Theme: {{ themeDisplayName }}
      </h1>

      <PrimaryButton v-if="!showThemes" @click="showThemes = !showThemes"
        class="col-span-3 lg:col-span-2 justify-center">
        Change theme
      </PrimaryButton>

      <SecondaryButton v-else @click="cancel" class="col-span-3 lg:col-span-2 justify-center">
        Cancel
      </SecondaryButton>
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