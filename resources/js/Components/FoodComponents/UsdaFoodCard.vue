<script setup>
const props = defineProps(['foodItem']);

const emit = defineEmits(['setActive']);

function setActive(item) {
  emit('setActive', item);
}
</script>


<template>

  <button @click="setActive(foodItem)" :style="{ backgroundImage: 'url(' + foodItem.photo + ')' }"
    :class="foodItem.photo ? 'text-white text-shadow-2xl' : 'text-dark-text'"
    class="group h-full w-full min-h-24  bg-center bg-cover hover:text-light-text border-4 border-dark/50 hover:border-accent rounded-sm  duration-300 drop-shadow">
    <div
      class="h-full w-full flex flex-col justify-center items-center bg-dark/50 group-hover:bg-dark/90 rounded-sm px-1 sm:px-2 py-2 sm:py-4 duration-300">
      <h1 class="text-sm sm:text-base font-bold">
        {{ foodItem.description }}
      </h1>
      <p class="text-xs" v-if="foodItem.gtinUpc && foodItem.brandOwner">
        ( {{ foodItem.brandName + [foodItem.brandName ? ' by' : ''] }} {{ foodItem.brandOwner }} )
      </p>
    </div>

  </button>

</template>
