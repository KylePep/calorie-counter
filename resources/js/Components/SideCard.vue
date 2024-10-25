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
  <section :class="sideClasses" class="flex flex-col space-y-2 md:min-h-96 px-6 sm:px-6 lg:px-8 py-6 ">
    <slot />
  </section>
</template>
