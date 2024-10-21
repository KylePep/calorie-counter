<script setup>
import { computed } from "vue";

const props = defineProps(['currentSize', 'size']);

const emit = defineEmits(['update:currentSize']);

const icon = computed(() => {
  return {
    'sm': 'mdi mdi-crop-square',
    'lg': 'mdi mdi-grid-large',
    'xl': 'mdi mdi-grid',
  }[props.size]
})

const isActive = computed(() => props.currentSize == props.size);

</script>

<template>
  <button @click="emit('update:currentSize', props.size)"
    :class="[isActive ? 'bg-neutral text-text-light' : 'bg-accent hover:bg-dark text-text-dark hover:text-text-light']"
    class=" rounded-md px-3 ">
    <i :class="icon"></i>
  </button>
</template>
