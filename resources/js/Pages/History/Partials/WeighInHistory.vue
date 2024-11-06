<script setup>
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";
import DateInput from "@/Components/Form/DateInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(['weighIns']);

const form = useForm({
  weight: null,
  date: null
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
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

};


</script>


<template>
  <div class="w-full">

    <CollapsableFolder :state="false">

      <template #title>
        <p> Weigh In History</p>
      </template>

      <template #content>
        <form @submit.prevent="createWeighIn" class="mb-2">
          <InputLabel for="weighIn" value="Create a new weigh in?" />
          <div class="flex space-x-2">
            <div class="relative  ">
              <NumberInput v-model="form.weight" id="weight" class="w-full" />
              <span
                class="absolute h-full flex items-center px-3 top-0 right-0 text-neutral-text/50 font-bold">lbs</span>
            </div>
            <div>
              <DateInput v-model="form.date" id="date" />
            </div>
          </div>
          <InputError :message="form.errors.weight" />
          <InputError :message="form.errors.date" />

          <div class="flex justify-end my-1">
            <PrimaryButton>Create</PrimaryButton>
          </div>
        </form>

        <div v-for="weighIn in props.weighIns" :key="weighIn.id" class="my-1">
          <button @click="deleteWeighIn(weighIn)"
            class="group relative flex w-full justify-between bg-main hover:bg-dark rounded font-bold text-dark-text hover:text-neutral-text px-4 py-0.5 duration-500">
            <p>
              {{ weighIn.weight }} lbs
            </p>
            <p>
              {{ new Date(weighIn.created_at).toDateString() }}
            </p>
            <p
              class="absolute left-1/2  object-center group-hover:text-special text-transparent font-bold mdi mdi-close-thick duration-300">
            </p>

          </button>
        </div>
      </template>

    </CollapsableFolder>
  </div>
</template>
