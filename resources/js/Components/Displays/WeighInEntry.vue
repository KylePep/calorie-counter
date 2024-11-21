<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "../Form/InputLabel.vue";
import NumberInput from "../Form/NumberInput.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import CollapsableFolder from "./CollapsableFolder.vue";
import Pop from "@/utils/Pop.js";
import MenuButton from "../Menu/MenuButton.vue";

const props = defineProps(['weighIn', 'date']);

const form = useForm({
  weight: null,
  date: props.date ?? null
});

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

async function deleteWeighIn(weighIn) {

  const confirmDelete = await Pop.confirm(`Delete ${weighIn.weight} - ${new Date(weighIn.created_at).toDateString()} Weigh In?`)
  if (!confirmDelete) {
    return
  }

  form.delete(route('weighIn.destroy', weighIn.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Removed ${new Date(weighIn.created_at).toDateString()} Weigh In`);
      form.reset();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

};

</script>


<template>
  <div v-if="!weighIn" class="w-full">

    <CollapsableFolder :state="false">

      <template #title>
        <p> Weigh In</p>
      </template>

      <template #content>
        <form @submit.prevent="createWeighIn">
          <InputLabel for="weighIn" value="Weigh In" class="hidden" />
          <div class="relative">
            <NumberInput v-model="form.weight" class="w-full mb-1" placeholder="Create a new weigh in?" required />
            <span class="absolute h-full flex items-center px-3 top-0 right-0 text-neutral-text/50 font-bold">lbs</span>
          </div>
          <div class="flex justify-end space-x-2">
            <PrimaryButton>Submit</PrimaryButton>
          </div>
        </form>
      </template>

    </CollapsableFolder>
  </div>
  <div v-else class="w-full ">
    <MenuButton @click="deleteWeighIn(weighIn)" class="group flex justify-between">
      <p>
        {{ weighIn.weight }} lbs
      </p>
      <p>
        Today
      </p>
      <p
        class="absolute left-1/2  object-center group-hover:text-light-text text-transparent font-bold mdi mdi-close-thick duration-300">
      </p>

    </MenuButton>
  </div>
</template>