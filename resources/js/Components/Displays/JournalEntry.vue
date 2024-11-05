<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import Pop from "@/utils/Pop.js";
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";

const props = defineProps(['calorieDay']);

const form = useForm({
  journal: props.calorieDay.journal
})

const promptSelector = () => {
  const journalPrompts = [
    "How did the food you ate today make you feel physically and emotionally?",
    "What was your favorite meal today, and why do you think it appealed to you?",
    "Did you feel satisfied after eating, and how long did that feeling last?",
    "Did you make any food choices today with specific health goals in mind?",
    "Were there any foods today that you felt were especially nourishing or beneficial for your health?",
    "How would you rate your overall energy levels throughout the day, and how might your food choices have influenced that?"
  ];
  const randomIndex = Math.floor(Math.random() * (journalPrompts.length));
  return journalPrompts[randomIndex];
}

function clearJournal() {
  form.journal = '';
  updateJournal()
}

async function updateJournal() {

  form.patch(route('calorieDay.patch', props.calorieDay.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Journal Entry updated`);
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
        <p> Journal Entry</p>
      </template>

      <template #content>
        <form @submit.prevent="updateJournal">
          <InputLabel for="journal" value="Journal Entry" class="hidden" />
          <textarea id="journal" v-model="form.journal" :placeholder="promptSelector()"
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