<script setup>
import { computed } from "vue";


const props = defineProps(['icon']);

const iconClass = computed(() => {
  return {
    pencil: 'mdi mdi-pencil',
    star: 'mdi mdi-star',
    plus: 'mdi mdi-plus-thick',
    delete: 'mdi mdi-delete',
    signUp: 'mdi mdi-account-plus'
  }[props.icon];
})

</script>

<template>

  <div class=" group flex justify-end items-center">

    <button aria-label="food item action"
      class="group min-w-8 relative flex items-center justify-end text-xl bg-accent-dark border-b-2 border-accent text-white  rounded group-hover:bg-light group-hover:border-neutral ps-2 transition ease-in-out duration-300">
      <span
        class="hidden sm:block text-xs px-1 left-0 group-hover:-translate-x-0 text-transparent group-hover:text-main ease-in-out text-sm me-1 translate-x-10 delay-0 group-hover:delay-300 transition ">
        <slot />
      </span>
      <span :class="iconClass"
        class="text-sm mdi pe-2 rounded bg-accent-dark group-hover:bg-light group-hover:text-dark scale-90 group-hover:scale-100 transition ease-in-out duration-300"></span>
    </button>
  </div>

</template>