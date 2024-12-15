<script setup>
import { computed } from "vue";


const displayMode = defineModel('displayMode');

function buttonClasses(mode, button) {
  return mode === button
    ? 'bg-neutral text-light-text'
    : 'bg-gradient-to-br from-accent to-accent-light border border-dark rounded font-bold text-dark-text hover:from-dark hover:to-neutral focus:from-dark focus:to-neutral hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-accent-light/20';
}

</script>

<template>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-white rounded border border-light shadow-lg p-3">
    <div class="flex items-center col-span-2 font-bold px-2">
      Display: <span class="ms-2 font-normal uppercase">{{ displayMode }}</span>
    </div>
    <button aria-label="list mode" @click="displayMode = 'list'" :class="buttonClasses(displayMode, 'list')"
      class="flex justify-center rounded"> <span class="hidden sm:block">List</span>
      <i class="ms-2 mdi mdi-card-text"></i>
    </button>

    <button aria-label="bar mode" @click="displayMode = 'bar'" :class="buttonClasses(displayMode, 'bar')"
      class="flex justify-center rounded"><span class="hidden sm:block">Progress
        Bar</span> <i class="ms-2 mdi mdi-poll rotate-90"></i>
    </button>
  </div>
</template>
