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

  <section class="border-light lg:pt-0 text-sm px-6 pt-4 sm:pt-0">
    <div :class="sideClasses" class="flex flex-col space-y-4 px-0 sm:px-6 lg:px-8 py-0 sm:py-6 ">
      <slot />
    </div>
  </section>

</template>
