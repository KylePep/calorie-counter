<script setup>
import Checkbox from "@/Components/Form/Checkbox.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps(['account']);
const account = computed(() => {
  props.account.trackMacros = Boolean(props.account.trackMacros);
  return props.account;
})
console.log(account.value)
const form = useForm(account.value ?? { peanut: 'butter' });

function updateAccount() {

  form.put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success('Macros set!')
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

}

</script>


<template>
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">

    {{ form }}
    <h1 class="font-bold">
      Macros
    </h1>
    <p class="mt-2">
      carbohydrates, proteins, and fats- the essential nutrients that provide energy and support bodily functions.
    </p>

    <form @submit.prevent="updateAccount" class="my-3">
      <div class="flex flex-col space-y-2">
        <div class="flex space-x-4">
          <Checkbox name="trackMacros" class="h-6 w-6 group-hover:text-accent" v-model:checked="form.trackMacros"
            :checked="Boolean(form.trackMacros)" />
          {{ Boolean(form.trackMacros) }}
          <p>Track Macros</p>
        </div>

        <div v-for=" macro, index in form.macros" :key="index" class="grid grid-cols-4">
          <InputLabel class="flex items-center col-span-4 sm:col-span-1 ">
            <h2 class="font-bold text-base">{{ index }} :</h2>

          </InputLabel>
          <div class="relative col-span-3 sm:col-span-2">
            <NumberInput v-model="form.macros[index]" class="w-full" />
            <span class="absolute h-full top-0 right-0 flex items-center pe-2 font-bold text-dark-text/50">Grams</span>
          </div>
          <p class="flex items-center ps-2">
            Per Day
          </p>
        </div>

        <div>
          <PrimaryButton>Update</PrimaryButton>
        </div>
      </div>
    </form>
  </div>
</template>