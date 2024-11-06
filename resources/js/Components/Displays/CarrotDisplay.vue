<script setup>
import { useForm } from "@inertiajs/vue3";
import CollapsableFolder from "./CollapsableFolder.vue";
import Pop from "@/utils/Pop.js";

const props = defineProps(['carrots']);

function carrotState(carrot) {
  const valueDifference = carrot.category === 'weighLoss'
    ? carrot.currentValue - carrot.value
    : carrot.value - carrot.currentValue;

  return valueDifference >= 0
    ? 'success'
    : 'fail'
}

function comparisonClasses(carrot) {

  const valueClass = carrotState(carrot);

  return {
    success: 'text-special font-bold animate-pulse bg-main rounded px-1',
    fail: 'text-neutral',
  }[valueClass];

}

function completeCarrot(carrot) {
  const form = useForm(carrot);
  form.complete = true;

  form.put(route('carrot.update', carrot.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Carrot ${form.description} completed!`);
      form.reset();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

</script>

<template>

  <div class="w-full">

    <CollapsableFolder :state="false">

      <template #title>
        <p> Carrots</p>
      </template>

      <template #content>
        <p class="font-bold">Incomplete</p>
        <div v-if="props.carrots.incomplete">
          <div v-for="carrot in props.carrots.incomplete" :key="carrot.id" class="font-bold flex justify-between">
            <div>
              {{ carrot.description }} - {{ carrot.goalPost }}
            </div>
            <div v-if="carrot.currentValue" :class="comparisonClasses(carrot)">
              {{ carrotState(carrot) != 'success' ? Math.abs(carrot.value - carrot.currentValue) : '' }}

              <button @click="completeCarrot(carrot)" v-if="carrotState(carrot) == 'success'">Success!</button>
              <span v-else>to go</span>
            </div>
          </div>
        </div>
        <div v-else>
          No incomplete carrots
        </div>

        <div v-if="props.carrots.complete">
          <p class="font-bold">Complete</p>
          <div v-for="carrot in props.carrots.complete" :key="carrot.id" class=" flex justify-between">
            {{ carrot.description }}
          </div>
        </div>

      </template>

    </CollapsableFolder>
  </div>
</template>
