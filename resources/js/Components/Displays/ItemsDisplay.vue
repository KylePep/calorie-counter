<script setup>
import { computed, ref } from "vue";
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";
import SizeButton from './SizeButton.vue'
import CollapsableFolder from "./CollapsableFolder.vue";

const props = defineProps(['list', 'size']);
const emit = defineEmits(['itemActivated', 'extraButton']);

const currentSize = ref(props.size);

function emitItemActivated(item) {
  emit('itemActivated', item);
}

function handleExtraButton(item, action) {
  emit('extraButton', item, action);
}


const maxSize = computed(() => {
  if (props.list.length < 5 && props.list.length >= 0) {
    return 'sm';
  } else if (props.list.length < 8) {
    return 'lg';
  } else {
    return 'xl';
  }
})

const currentSizeClass = computed(() => {
  let newSize = {
    sm: 'grid-rows-1',
    lg: 'grid-rows-2',
    xl: 'grid-rows-3',
  }[currentSize.value];

  if (maxSize.value == 'lg') {
    if (currentSize.value == 'xl') {
      newSize = 'lg';
      currentSize.value = 'lg';
    }
  } else if (maxSize.value == 'sm') {
    if (currentSize.value == 'xl' || currentSize.value == 'lg') {
      newSize = 'sm';
      currentSize.value = 'sm';
    }
  }

  return newSize;
});

</script>

<template>

  <CollapsableFolder :state="Boolean(props.list.length)">

    <template #title>
      <slot />
    </template>

    <template #config>
      <div class="flex items-center space-x-2 ">
        <SizeButton v-model:currentSize="currentSize" size="sm" />
        <div v-if="maxSize == 'lg' || maxSize == 'xl'" @click="currentSize = 'lg'">
          <SizeButton v-model:currentSize="currentSize" size="lg" />
        </div>
        <div v-if="maxSize == 'xl'" @click="currentSize = 'xl'">
          <SizeButton v-model:currentSize="currentSize" size="xl" />
        </div>
      </div>
    </template>

    <template #content>
      <div class=" grid grid-flow-col auto-cols-min gap-3 p-2 text-center overflow-x-auto whitespace-nowrap"
        :class="currentSizeClass">

        <div v-for="foodItem in props.list">
          <FoodCard :foodItem="foodItem" @itemActivated="emitItemActivated" @extraButton="handleExtraButton" />
        </div>

        <div v-if="props.list.length == 0"
          class="inline-block justify-center text-center text-light-text font-bold w-60 bg-neutral border border-light rounded drop-shadow-lg">
          <div class="flex flex-col min-h-24 justify-around">
            <p>
              No foods to show
            </p>
          </div>
        </div>
      </div>

    </template>

    <Transition enter-active-class="ease-out duration-300" enter-from-class="scale-y-0 max-h-0 opacity-0"
      enter-to-class="scale-y-100 max-h-[1000px] opacity-100" leave-active-class="ease-in duration-200"
      leave-from-class="scale-y-100 max-h-[1000px] opacity-100" leave-to-class="scale-y-0 max-h-0 opacity-0">


    </Transition>

  </CollapsableFolder>

</template>
