<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

const displayMode = defineModel('displayMode');
</script>

<template>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-white rounded border border-light shadow-lg p-3">
    <div class="flex items-center col-span-2 font-bold">
      Display Modes:
    </div>
    <PrimaryButton @click="displayMode = 'list'" class="flex justify-center"> <span class="hidden sm:block">List</span>
      <i class="ms-2 mdi mdi-card-text"></i>
    </PrimaryButton>
    <PrimaryButton @click="displayMode = 'bar'" class="flex justify-center"><span class="hidden sm:block">Progress
        Bar</span> <i class="ms-2 mdi mdi-poll rotate-90"></i>
    </PrimaryButton>
  </div>
</template>
