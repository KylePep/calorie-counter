<script setup>

const props = defineProps(['bgColor'])

</script>


<template>
  <div>

    <div :class="props.bgColor" class=" text-dark-text px-2 py-1 rounded">
      <slot />
    </div>

    <div>
      Results
    </div>

  </div>
</template>