<script setup>
import { computed } from "vue";

const props = defineProps(['currentSize', 'size']);

const emit = defineEmits(['update:currentSize']);

const icon = computed(() => {
  return {
    'sm': 'mdi mdi-crop-square',
    'lg': 'mdi mdi-grid-large',
    'xl': 'mdi mdi-grid',
  }[props.size];
})

const isActive = computed(() => props.currentSize == props.size);

</script>

<template>
  <button @click="emit('update:currentSize', props.size)"
    :class="[isActive ? 'bg-neutral text-light-text' : 'bg-gradient-to-br from-accent to-accent-light border border-dark rounded font-bold text-dark-text hover:from-dark hover:to-neutral focus:from-dark focus:to-neutral hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-accent-light/20']"
    class=" rounded-md px-3 ">
    <i :class="icon"></i>
  </button>
</template>