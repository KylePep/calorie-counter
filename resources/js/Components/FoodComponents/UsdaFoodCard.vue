<script setup>
const props = defineProps(['foodItem']);

</script>


<template>

  <button @click="emitExtraButton(foodItem, 'edit')"
    class="h-full flex flex-col justify-center items-center bg-main hover:bg-dark text-dark-text hover:text-light-text border-4 border-transparent hover:border-accent rounded-sm px-2 py-4 duration-300">

    <h1 class="text-sm sm:text-base font-bold text-balance truncate"
      :class="[foodItem.gtinUpc ? 'text-base' : 'text-lg']">
      {{ foodItem.description }}
    </h1>
    <p class="text-xs" v-if="foodItem.gtinUpc && foodItem.brandOwner">
      ( {{ foodItem.brandName + [foodItem.brandName ? ' by' : ''] }} {{ foodItem.brandOwner }} )
    </p>

  </button>

</template>
