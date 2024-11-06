<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "../Form/InputLabel.vue";
import NumberInput from "../Form/NumberInput.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import CollapsableFolder from "./CollapsableFolder.vue";
import Pop from "@/utils/Pop.js";

const form = useForm({
  weight: null
})

async function createWeighIn() {

  form.post(route('weighIn.store'), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Weigh in added.`);
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
        <p> Weigh In</p>
      </template>

      <template #content>
        <form @submit.prevent="createWeighIn">
          <InputLabel for="weighIn" value="Weigh In" class="hidden" />
          <div class="relative">
            <NumberInput v-model="form.weight" class="w-full mb-1" placeholder="Create a new weigh in?" />
            <span class="absolute h-full flex items-center px-3 top-0 right-0 text-neutral-text/50 font-bold">lbs</span>
          </div>
          <div class="flex justify-end space-x-2">
            <PrimaryButton>Submit</PrimaryButton>
          </div>
        </form>
      </template>

    </CollapsableFolder>
  </div>
</template>