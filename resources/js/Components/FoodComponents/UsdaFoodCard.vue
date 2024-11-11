<script setup>

const emit = defineEmits(['extraButton']);

const props = defineProps(['foodItem']);

function emitExtraButton(item, action) {
  emit('extraButton', item, action);
}
</script>


<template>

  <button @click="emitExtraButton(foodItem, 'edit')"
    class="group h-full w-full min-h-24 flex flex-col justify-center items-center bg-main hover:bg-dark text-dark-text hover:text-light-text border-4 border-transparent hover:border-accent rounded-sm px-1 sm:px-2 py-2 sm:py-4 duration-300 drop-shadow-lg">

    <h1 class="text-sm sm:text-base font-bold">
      {{ foodItem.description }}
    </h1>
    <p class="text-xs" v-if="foodItem.gtinUpc && foodItem.brandOwner">
      ( {{ foodItem.brandName + [foodItem.brandName ? ' by' : ''] }} {{ foodItem.brandOwner }} )
    </p>

  </button>

</template>
