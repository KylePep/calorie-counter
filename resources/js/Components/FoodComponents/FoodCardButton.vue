<script setup>
import { computed } from "vue";


const props = defineProps(['icon'])

const iconClass = computed(() => {
  return {
    pencil: 'mdi mdi-pencil',
    star: 'mdi mdi-star',
    plus: 'mdi mdi-plus-thick',
    delete: 'mdi mdi-delete',
    signUp: 'mdi mdi-account-plus'
  }[props.icon]
})

</script>

<template>

  <div class=" group flex justify-end items-center h-full">

    <button
      class="group min-w-8 relative flex items-center justify-end text-xl bg-accent text-dark-text rounded group-hover:bg-neutral focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 ps-2 transition ease-in-out duration-300">
      <span
        class="text-xs px-1 left-0 group-hover:-translate-x-0 group-hover:text-main text-transparent ease-in-out text-sm me-1 translate-x-10 delay-0 group-hover:delay-300 transition ">
        <slot />
      </span>
      <span :class="iconClass"
        class="text-sm mdi pe-2 rounded-xl bg-accent group-hover:bg-neutral group-hover:text-main scale-90 group-hover:scale-100 transition ease-in-out duration-300"></span>
    </button>
  </div>

</template>