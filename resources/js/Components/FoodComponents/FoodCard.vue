<script setup>
import { usePage } from "@inertiajs/vue3";
import FoodCardButton from "./FoodCardButton.vue";

const props = defineProps(['foodItems'])
const emit = defineEmits(['itemActivated', 'extraButton'])

const page = usePage();
const isDashboard = page.url.includes('dashboard')

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function emitExtraButton(item, action) {
  emit('extraButton', item, action);
}

</script>

<template>

  <div v-for="item in foodItems" :key="item">

    <section
      class="flex flex-col break-inside-avoid hover:bg-gray-200 bg-gray-300  rounded-t border-4 border-black/25 pb-3 min-h-40 max-w-80">

      <div class="grid grid-cols-3 gap-1 bg-gray-200 justify-between items-end px-1 border-b-2 border-black/25">

        <div class=" text-gray-800 font-bold text-3xl drop-shadow-2xl ">
          {{ item.calories }}
        </div>

        <FoodCardButton @click.stop="emitExtraButton(item, 'edit')" icon="pencil">Edit</FoodCardButton>
        <FoodCardButton v-if="isDashboard" @click.stop="emitExtraButton(item, 'add')" icon="plus">Add</FoodCardButton>
        <FoodCardButton v-if="!isDashboard" @click.stop="emitExtraButton(item, 'delete')" icon="delete">Delete
        </FoodCardButton>

      </div>

      <div @click="emitItemActivated(item)" class="text-gray-800 font-bold p-3 drop-shadow-2xl my-auto">
        <h1 class="font-bold text-wrap">{{ item.description }}</h1>
      </div>

    </section>

    <section
      class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-1 max-w-80 p-1 border-4 border-t-0 border-black/25 bg-gray-300">
      <div v-for="block in Math.round(item.calories / 50) " class="bg-gray-700 h-4 border-2 border-black rounded-sm">
      </div>
    </section>



  </div>

</template>
