<script setup>
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../Form/PrimaryButton.vue";
import NumberInput from "../Form/NumberInput.vue";
import InputLabel from "../Form/InputLabel.vue";


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
  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Weigh In</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">It isn't necessary to create a new weigh in for every day. Just do
      what feels right.
    </h2>

    <div v-if="!weighIn" class="w-full">
      <form @submit.prevent="createWeighIn">
        <InputLabel for="weighIn" value="Weigh In" class="hidden" />
        <div class="relative">
          <NumberInput v-model="form.weight" class="w-full " placeholder="Create a new weigh in?" required />
          <span class="absolute h-full flex items-center px-3 top-0 right-0 text-neutral-text/50 font-bold">lbs</span>
        </div>
        <div class="flex justify-end space-x-2 mt-3">
          <PrimaryButton>Submit</PrimaryButton>
        </div>
      </form>
    </div>

    <div v-else class="w-full">
      <button @click="deleteWeighIn(weighIn)"
        class="group relative flex w-full justify-between bg-main hover:bg-dark rounded font-bold text-dark-text hover:text-light-text border py-2.5 px-3 bg-light border-light rounded duration-500">
        <p>
          {{ weighIn.weight }} lbs
        </p>
        <p>
          Today
        </p>
        <p
          class="absolute left-1/2  object-center group-hover:text-light-text text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </button>
    </div>
  </div>
</template>