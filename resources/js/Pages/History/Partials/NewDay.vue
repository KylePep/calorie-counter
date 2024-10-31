<script setup>
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  date: ''
})

async function createCalorieDay() {

  form.post(route('calorieDay.store'), {
    onSuccess: () => {
      Pop.success(`Calorie Day created!`);
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
        <p> Add a day</p>
      </template>

      <template #content>
        <form @submit.prevent="createCalorieDay" class="flex flex-col justify-between items-end space-y-2">
          <input v-model="form.date" class="w-full" type="date" name="" id="">
          <PrimaryButton>Create New Day</PrimaryButton>
        </form>
      </template>
    </CollapsableFolder>
  </div>

</template>