<script setup>
</script>

<template>
  <button
    class="flex justify-center items-center w-full px-2 py-1 lg:py-2 bg-gradient-to-br from-accent/50 to-accent-light/50 border-2 border-accent-dark rounded font-bold text-xs text-neutral-text uppercase tracking-widest hover:from-accent hover:to-accent-light focus:from-accent focus:to-accent-light hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150">
    <slot />
  </button>
</template>
