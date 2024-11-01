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

  <section class="border-light text-sm px-6 pt-4 sm:pt-0">
    <div :class="sideClasses" class="flex flex-col space-y-4 px-0 py-0 sm:pt-4">
      <slot />
    </div>
  </section>

</template>
