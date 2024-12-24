<script setup>
import { ref } from "vue";
import UsdaSearch from "./UsdaSearch.vue";
import FoodItemSearch from "./FoodItemSearch.vue";


const displayMode = ref('app')

const emit = defineEmits(['setActive']);

function setActive(item) {
  const type = form.type != 'App' ? 'usda' : 'app'
  emit('setActive', type, item);
}

function buttonClasses(mode, button) {
  return mode === button
    ? 'bg-neutral text-light-text'
    : 'bg-gradient-to-br from-accent to-accent-light border border-dark rounded font-bold text-dark-text hover:from-dark hover:to-neutral focus:from-dark focus:to-neutral hover:text-white focus:text-white active:bg-gray-900 transition ease-in-out duration-150 shadow-inner shadow-accent-light/20';
}

</script>

<template>
  <div class="space-y-4">

    <section class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-white rounded border border-light shadow-lg p-3">
      <div class="flex items-center col-span-2 font-bold px-2">
        Search for food: <span class="ms-2 font-normal uppercase">{{ displayMode }}</span>
      </div>
      <button aria-label="app mode" @click="displayMode = 'app'" :disabled="displayMode == 'app'"
        :class="buttonClasses(displayMode, 'app')" class="flex justify-center rounded"> APP
      </button>

      <button aria-label="usda mode" @click="displayMode = 'usda'" :disabled="displayMode == 'usda'"
        :class="buttonClasses(displayMode, 'usda')" class="flex justify-center rounded">USDA
      </button>
    </section>

    <section v-if="displayMode == 'usda'">
      <UsdaSearch @set-active="setActive" />
    </section>

    <section v-else>
      <FoodItemSearch @setActive="setActive" />
    </section>
  </div>

</template>