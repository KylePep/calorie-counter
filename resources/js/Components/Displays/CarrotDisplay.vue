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
    success: 'text-white font-bold animate-pulse bg-green-500 rounded px-1 hover:bg-green-800 hover:text-light-text border border-dark',
    fail: 'text-neutral',
  }[valueClass];

}

function completeCarrot(carrot) {
  const form = useForm(carrot);
  form.transform((data) => ({
    ...data,
    complete: true
  }))
    .put(route('carrot.update', carrot.id), {
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
        <div class="space-y-3">
          <h3 class="font-bold mdi mdi-human-male">Incomplete</h3>
          <div v-if="props.carrots.incomplete">
            <div v-for="carrot in props.carrots.incomplete" :key="carrot.id"
              class="bg-main px-2 py-1 rounded-sm my-1 font-bold text-xs flex justify-between">
              <div class="flex items-center">
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
            <h3 class="font-bold mdi mdi-weight-lifter">Completed</h3>
            <div v-for="carrot in props.carrots.complete" :key="carrot.id"
              class="bg-neutral text-light-text px-2 py-1 rounded-sm my-1 font-bold text-xs flex justify-between">
              {{ carrot.description }} - {{ carrot.goalPost }}
            </div>
          </div>
        </div>

      </template>

    </CollapsableFolder>
  </div>
</template>
