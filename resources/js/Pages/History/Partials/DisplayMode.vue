<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

const displayMode = defineModel('displayMode');


</script>

<template>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-white rounded border border-light shadow-lg p-3">
    <div class="flex items-center col-span-2 font-bold px-2">
      Display: <span class="ms-2 font-normal uppercase">{{ displayMode }}</span>
    </div>
    <button @click="displayMode = 'list'"
      :class="[displayMode == 'list' ? 'bg-neutral text-light-text' : 'bg-accent hover:bg-dark text-dark-text hover:text-light-text']"
      class="flex justify-center rounded"> <span class="hidden sm:block">List</span>
      <i class="ms-2 mdi mdi-card-text"></i>
    </button>

    <button @click="displayMode = 'bar'"
      :class="[displayMode == 'bar' ? 'bg-neutral text-light-text' : 'bg-accent hover:bg-dark text-dark-text hover:text-light-text']"
      class="flex justify-center rounded"><span class="hidden sm:block">Progress
        Bar</span> <i class="ms-2 mdi mdi-poll rotate-90"></i>
    </button>
  </div>
</template>
