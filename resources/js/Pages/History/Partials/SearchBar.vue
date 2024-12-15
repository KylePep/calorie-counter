<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import DateInput from "@/Components/Form/DateInput.vue";
import MonthInput from "@/Components/Form/MonthInput.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";

const props = defineProps(['results']);


const searchResults = computed(() => props.results || ['Last 31 Results'])

const form = useForm({
  month: '',
  day: ''
})

async function searchHistory(type) {
  if (type == 'day') {
    form.month = null;
  } else if (type == 'month') {
    form.day = null;
  } else {
    form.day = null;
    form.month = null;
  }
  form.get(route('history.search'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}
</script>


<template>
  <form @submit.prevent="" class="grid grid-cols-2 gap-2 bg-white rounded border border-light shadow-lg p-3">

    <div class="col-span-2 sm:col-span-1 grid grid-cols-2 space-x-2">
      <DateInput aria-label="Date Input" type="date" v-model="form.day" id="day" />
      <PrimaryButton @click="searchHistory('day')">Search day</PrimaryButton>
    </div>

    <div class="col-span-2 sm:col-span-1 grid grid-cols-2 space-x-2">
      <MonthInput aria-label="Month Input" type="month" v-model="form.month" id="month" />
      <PrimaryButton @click="searchHistory('month')">Search Month</PrimaryButton>
    </div>

    <div class="col-span-2 grid grid-cols-4 gap-3">
      <div class="col-span-4 sm:col-span-3 flex items-center px-2">
        <span class="font-bold me-2">Showing:</span> {{ searchResults[0] }} <span v-if="searchResults.length > 1"
          class="ms-1">to
          {{
            searchResults[1] }}</span>
      </div>
      <SecondaryButton @click="searchHistory('clear')">Clear</SecondaryButton>
    </div>

  </form>
</template>
