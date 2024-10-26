<script setup>
import { computed } from "vue";
import SideCard from "./SideCard.vue";

const props = defineProps(['side'])

const sideClasses = computed(() => {
  return {
    'left': 'border-b lg:border-b-0 lg:border-e',
    'right': 'border-t lg:border-t-0 lg:border-s'
  }[props.side];
})

</script>


<template>
  <section class="border-light space-y-3 lg:pt-0 text-sm px-6 pt-6 md:pt-12">
    <SideCard :side="props.side">
      <slot />
    </SideCard>
  </section>
</template>


<style lang="scss" scoped></style>