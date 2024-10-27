<script setup>
const props = defineProps({
  account: {
    type: Object,
  }
});
</script>


<template>
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    Edit Carrot
  </div>
</template>
