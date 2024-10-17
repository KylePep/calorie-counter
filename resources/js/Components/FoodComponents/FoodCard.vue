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

  <div class="flex flex-col w-60 drop-shadow-lg" v-for="item in foodItems" :key="item">

    <section class="flex flex-col break-inside-avoid  bg-gray-300 flex-1 rounded-t border-2 border-black/25  ">

      <div class="grid grid-cols-3 gap-1 bg-gray-200 justify-between items-end py-1 px-1 border-b-2 border-black/25">

        <div class=" text-gray-800 font-bold ">
          {{ item.calories }}
        </div>

        <FoodCardButton @click.stop="emitExtraButton(item, 'edit')" icon="pencil">Edit</FoodCardButton>
        <FoodCardButton v-if="isDashboard" @click.stop="emitExtraButton(item, 'add')" icon="plus">Add</FoodCardButton>
        <FoodCardButton v-if="!isDashboard" @click.stop="emitExtraButton(item, 'delete')" icon="delete">Delete
        </FoodCardButton>

      </div>

      <div @click="emitItemActivated(item)"
        class="flex-1 text-gray-800 hover:bg-gray-200 hover:cursor-pointer font-bold p-3 ">
        <h1 class="font-bold text-wrap text-lg">{{ item.description }}</h1>
      </div>

    </section>

    <section
      class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-1 p-1 border-2 border-t-0 border-black/25 bg-gray-300">
      <div v-for="block in Math.round(item.calories / 50) " title="50 Calories"
        class="bg-gray-400 h-2 border-2 border-black/25 rounded-sm">
      </div>
    </section>



  </div>

</template>
