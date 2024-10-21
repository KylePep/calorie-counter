<script setup>
import { usePage } from "@inertiajs/vue3";
import FoodCardButton from "./FoodCardButton.vue";

const props = defineProps(['foodItem'])
const emit = defineEmits(['itemActivated', 'extraButton'])

const page = usePage();
const isDashboard = page.url.includes('dashboard')

function emitExtraButton(item, action) {
  emit('extraButton', item, action);
}

</script>

<template>

  <div class="flex flex-col h-full w-60 drop-shadow-lg">

    <section class="flex flex-col break-inside-avoid flex-1 rounded-t border-2 border-neutral  ">

      <div class="flex bg-main justify-between items-end py-1 px-2 border-b-2 border-neutral">

        <div class=" text-text font-bold ">
          {{ foodItem.calories }}
        </div>

        <div class="flex space-x-2">
          <FoodCardButton v-if="isDashboard" @click.stop="emitExtraButton(foodItem, 'add')" icon="plus">Add
          </FoodCardButton>
          <FoodCardButton v-if="!isDashboard" @click.stop="emitExtraButton(foodItem, 'delete')" icon="delete">Delete
          </FoodCardButton>
        </div>

      </div>

      <div @click="emitExtraButton(foodItem, 'edit')" :title="'Edit'"
        class="flex-1 text-text-light bg-neutral hover:bg-light hover:text-dark hover:cursor-pointer p-3 duration-300">
        <h1 class="text-sm truncate sm:text-balance ">{{ foodItem.description }}
        </h1>
      </div>

    </section>

    <section
      class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-0.5 p-1 border-2 border-t-0 border-neutral bg-dark rounded-b">
      <div v-for="block in Math.round(foodItem.calories / 50) " title="50 Calories"
        class="bg-accent h-3 border border-neutral rounded-sm">
      </div>
    </section>
  </div>

</template>
