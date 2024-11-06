<script setup>
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";
import DateInput from "@/Components/Form/DateInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  date: ''
})

async function createCalorieDay() {

  form.post(route('calorieDay.store'), {
    preserveScroll: true,
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
    <CollapsableFolder :state="false">
      <template #title>
        <p> Add a day</p>
      </template>

      <template #content>
        <form @submit.prevent="createCalorieDay" class="flex flex-col justify-between  items-end space-y-2">
          <div class="w-full mb-1 ">
            <InputLabel for="date" value="Date" class="hidden" />
            <DateInput id="date" class="w-full" v-model="form.date" />
            <InputError :message="form.errors.date" />
          </div>
          <PrimaryButton>Create New Day</PrimaryButton>
        </form>
      </template>
    </CollapsableFolder>
  </div>

</template>