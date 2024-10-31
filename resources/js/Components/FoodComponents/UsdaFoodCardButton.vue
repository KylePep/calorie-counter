<script setup>
import { computed } from "vue";


const props = defineProps(['icon'])

const iconClass = computed(() => {
  return {
    pencil: 'mdi mdi-pencil',
    star: 'mdi mdi-star',
    plus: 'mdi mdi-plus-thick',
    delete: 'mdi mdi-delete'
  }[props.icon]
})

</script>

<template>

  <div class=" group flex justify-end items-center h-full">

    <button
      class="group relative flex items-center justify-end text-xl bg-accent text-dark-text rounded-xl group-hover:bg-neutral focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 ps-2 transition ease-in-out duration-300">
      <span
        class="text-sm px-1 left-0 group-hover:-translate-x-0 group-hover:text-white text-transparent ease-in-out me-1 translate-x-10 delay-0 group-hover:delay-300 transition">
        <slot />
      </span>
      <span :class="iconClass"
        class="text-base mdi pe-2 rounded-xl bg-accent group-hover:bg-neutral group-hover:text-main scale-90 group-hover:scale-100 transition ease-in-out duration-300"></span>
    </button>
  </div>

</template>