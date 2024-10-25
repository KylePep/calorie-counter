<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "./InputLabel.vue";
import PrimaryButton from "./PrimaryButton.vue";
import SecondaryButton from "./SecondaryButton.vue";
import Pop from "@/utils/Pop.js";
import { ref } from "vue";

const showForm = ref(true);

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
    <div @click="showForm = !showForm"
      :class="showForm ? 'text-text border-b-0 rounded-t bg-light ' : 'bg-neutral text-text-light rounded shadow'"
      class="flex justify-between border-2 py-1 px-3 border-neutral w-48 sm:w-full duration-300">
      <p class="text-xl font-bold"> Journal Entry</p>

      <i :class="showForm ? 'mdi mdi-menu-up' : 'mdi mdi-menu-down'" class="mx-1  text-lg"></i>
    </div>

    <Transition enter-active-class="ease-out duration-300" enter-from-class="scale-y-0 max-h-0 opacity-0"
      enter-to-class="scale-y-100 max-h-[1000px] opacity-100" leave-active-class="ease-in duration-200"
      leave-from-class="scale-y-100 max-h-[1000px] opacity-100" leave-to-class="scale-y-0 max-h-0 opacity-0">
      <div v-show="showForm"
        class="origin-top p-2 bg-light border-2 rounded-b rounded-tr sm:rounded-tr-none  border-neutral ">
        <InputLabel value="Journal Entry" class="hidden" />
        <textarea v-model="form.entry"
          class="w-full h-52 resize-none border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"></textarea>
        <div class="flex justify-end space-x-2">
          <SecondaryButton type="button" @click="clearEntry">Clear</SecondaryButton>
          <PrimaryButton>Submit</PrimaryButton>
        </div>
      </div>
    </Transition>


  </form>
</template>