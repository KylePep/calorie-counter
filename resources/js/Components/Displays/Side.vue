<script setup>
import { computed } from "vue";

const props = defineProps(['side']);

const sideClasses = computed(() => {
  return {
    'left': 'items-end',
    'right': 'items-start'
  }[props.side];
})

</script>


<template>

  <!-- <section class="px-6 pt-4 sm:pt-0">
    <slot />
  </section> -->

</template>
