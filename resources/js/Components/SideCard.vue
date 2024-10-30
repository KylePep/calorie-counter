<script setup>
import { computed } from "vue";

const props = defineProps(['side'])

const sideClasses = computed(() => {
  return {
    'left': 'items-end',
    'right': 'items-start'
  }[props.side];
})

</script>

<template>
  <section :class="sideClasses" class="flex flex-col space-y-4 md:min-h-96 px-0 sm:px-6 lg:px-8 py-0 sm:py-6 ">
    <slot />
  </section>
</template>
