<script setup>
import { computed } from "vue";
import SideCard from "./SideCard.vue";

const props = defineProps(['side'])

const sideClasses = computed(() => {
  return {
    'left': 'border-b lg:border-b-0 lg:border-e border-light px-4 lg:px-12 pt-12 lg:pb-0 lg:pt-0 text-sm mx-12 lg:mx-0 min-h-60 space-y-4',
    'right': 'border-t lg:border-t-0 lg:border-s border-light space-y-3 px-4 lg:px-12 pt-12 lg:pt-0 text-sm mx-12 lg:mx-0 min-h-60'
  }[props.side];
})

</script>


<template>
  <section :class="sideClasses">
    <SideCard>
      <slot />
    </SideCard>
  </section>
</template>


<style lang="scss" scoped></style>