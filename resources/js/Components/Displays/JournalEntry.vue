<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import Pop from "@/utils/Pop.js";
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";

const props = defineProps(['calorieDay']);

const form = useForm({
  // entry: 'One time, one time I drank too much diet coke. I pooped my pants. I pooped my pants because I drank too much diet coke.'
  journal: props.calorieDay.journal
})

function clearJournal() {
  form.journal = '';
  updateJournal()
}

async function updateJournal() {
  // update day with new entry
  form.patch(route('calorieDay.patch', props.calorieDay.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Journal Entry updated`)
      closeModal()
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

</script>


<template>
  <div class="w-full">

    <CollapsableFolder>

      <template #title>
        <p class="font-bold text-lg"> Journal Entry</p>
      </template>

      <template #content>
        <form @submit.prevent="updateJournal">
          <InputLabel value="Journal Entry" class="hidden" />
          <textarea v-model="form.journal"
            class="w-full h-32 md:h-52 resize-none border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"></textarea>
          <div class="flex justify-end space-x-2">
            <SecondaryButton type="button" @click="clearJournal">Clear</SecondaryButton>
            <PrimaryButton>Submit</PrimaryButton>
          </div>
        </form>
      </template>

    </CollapsableFolder>
  </div>

</template>