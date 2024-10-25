<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "./InputLabel.vue";
import PrimaryButton from "./PrimaryButton.vue";
import SecondaryButton from "./SecondaryButton.vue";
import Pop from "@/utils/Pop.js";

const form = useForm({
  entry: 'One time, one time I drank too much diet coke. I pooped my pants. I pooped my pants because I drank too much diet coke.'
})

function clearEntry() {
  form.entry = '';
  //send update to calorieDay
}

async function updateEntry() {
  Pop.success('update triggered')
  //update day with new entry
  // form.put(route('food.update', props.foodItem.id), {
  //   preserveScroll: true,
  //   onSuccess: () => {
  //     Pop.success(`${form.description} updated`)
  //     form.reset()
  //     closeModal()
  //   },
  //   onError: (errors) => {
  //     console.log(errors);
  //   },
  // });
}

</script>


<template>
  <form @submit.prevent="updateEntry" class="w-full">
    <InputLabel value="Journal Entry" />
    <textarea v-model="form.entry"
      class="w-full h-52 resize-none border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"></textarea>
    <div class="flex justify-end space-x-2">
      <SecondaryButton type="button" @click="clearEntry">Clear</SecondaryButton>
      <PrimaryButton>Submit</PrimaryButton>
    </div>
  </form>
</template>