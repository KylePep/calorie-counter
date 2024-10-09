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
      class="group min-w-8 relative flex items-center justify-end text-xl bg-gray-600 text-white rounded-xl hover:bg-gray-800 ps-2 transition ease-in-out">
      <span
        class=" px-1 left-0 group-hover:-translate-x-0 group-hover:text-white text-transparent ease-in-out text-sm me-1 translate-x-10 delay-0 group-hover:delay-300 transition">
        <slot />
      </span>
      <span :class="iconClass"
        class="mdi pe-2 rounded-xl bg-gray-600 group-hover:bg-gray-800 scale-90 group-hover:scale-100 transition ease-in-out"></span>
    </button>
  </div>

</template>