<script setup>
import { computed, ref } from "vue";

const props = defineProps(['state']);

const showFolder = ref(props.state ?? true);

const showClasses = computed(() => {
  return {
    false: 'bg-neutral hover:bg-accent  text-sm sm:text-base text-light hover:text-dark border-transparent rounded shadow',
    true: 'text-lg text-text border-b-0 rounded-t bg-main '
  }[showFolder.value]
})

</script>


<template>


  <div class="flex justify-between">
    <button @click="showFolder = !showFolder" :class="showClasses, $slots.config ? 'w-48 sm:w-60 ' : 'w-full'"
      class="flex justify-between items-center font-bold border-2 py-1 px-3 border-neutral duration-300">
      <slot name="title" />
      <i :class="showFolder ? 'mdi mdi-menu-up' : 'mdi mdi-menu-down'" class="mx-1  text-lg"></i>
    </button>

    <Transition v-if="$slots.config" enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
      enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
      leave-to-class="opacity-0">
      <div v-show="showFolder">
        <slot name="config" />
      </div>
    </Transition>
  </div>


  <Transition enter-active-class="ease-out duration-300" enter-from-class="scale-y-0 max-h-0 opacity-0"
    enter-to-class="scale-y-100 max-h-[1000px] opacity-100" leave-active-class="ease-in duration-200"
    leave-from-class="scale-y-100 max-h-[1000px] opacity-100" leave-to-class="scale-y-0 max-h-0 opacity-0">

    <div v-show="showFolder" :class="$slots.config ? 'rounded-tr' : 'rounded-tr-none'"
      class="origin-top w-full p-2 bg-light border-2 rounded-b border-neutral mt-0 shadow-inner">
      <slot name="content" />
    </div>

  </Transition>

</template>