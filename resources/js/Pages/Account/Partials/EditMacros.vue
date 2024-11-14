<script setup>
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps(['account']);
const account = computed(() => {
  if (!props.account?.trackMacros) {
    return {};
  }
  props.account.trackMacros = Boolean(props.account.trackMacros);
  return props.account;
})
const form = useForm(account.value ?? { peanut: 'butter' });

const macroDesiredPercentages = ref({
  carbs: 45,
  protein: 50,
  fats: 20
})

function setMacro(macro) {
  switch (macro) {
    case 'carbohydrates':
      form.macros.carbohydrates = Math.round((account.value.goal) * (macroDesiredPercentages.value.carbs / 100) / 4);
      break;
    case 'protein':
      form.macros.protein = Math.round((account.value.weight) * (macroDesiredPercentages.value.protein / 100));
      break;
    case 'fats':
      form.macros.fats = Math.round((account.value.goal) * (macroDesiredPercentages.value.fats / 100) / 9);
      break;

    default:
      break;
  }
}

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
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12 space-y-4">
    <h1 class="font-bold">
      Macros
    </h1>
    <p class="mt-2">
      carbohydrates, proteins, and fats- the essential nutrients that provide energy and support bodily functions.
    </p>

    <div>
      <CollapsableFolder :state="false">
        <template #title>Macro Calculators</template>
        <template #config></template>
        <template #content>
          <div class="space-y-2 mb-4">
            <div class="grid grid-cols-4 gap-x-2">
              <div class="relative">
                <NumberInput v-model="macroDesiredPercentages.carbs" class="w-full sm:text-center" />
                <span class="absolute h-full top-0 right-0 flex items-center pe-2 font-bold text-dark-text/50">%</span>
              </div>
              <PrimaryButton @click="setMacro('carbohydrates')" type="button"
                class="col-span-3 sm:col-span-2 flex justify-center">Calculate
                Carbohydrates
              </PrimaryButton>
            </div>
            <p class="text-xs">
              * It is recommended that Carbohydrates make up 45% to 65% of total daily calories. <br> Formula: (Calorie
              Goal)
              x
              (Desired
              Carb
              Percentage/100) / 4 = Daily Carbs in Grams.
            </p>
          </div>

          <div class="space-y-2 my-4">
            <div class="grid grid-cols-4 gap-x-2">
              <div class="relative">
                <NumberInput v-model="macroDesiredPercentages.protein" class="w-full sm:text-center" />
                <span class="absolute h-full top-0 right-0 flex items-center pe-2 font-bold text-dark-text/50">%</span>
              </div>
              <PrimaryButton @click="setMacro('protein')" type="button"
                class="col-span-3 sm:col-span-2 flex justify-center">
                Calculate
                Proteins
              </PrimaryButton>
            </div>

            <p class="text-xs">
              * To increase muscle mass in combination with physical activity, it is recommended that a person that
              lifts
              weights regularly eat a range of 50% to 80% grams per pound of
              body weight per day. <br> Formula: Body weight (pounds) x (Desired Protein Percentage/100) = Daily protein
              intake in Grams.
            </p>
          </div>

          <div class="space-y-2 my-4">
            <div class="grid grid-cols-4 gap-x-2">
              <div class="relative">
                <NumberInput v-model="macroDesiredPercentages.fats" class="w-full sm:text-center" />
                <span class="absolute h-full top-0 right-0 flex items-center pe-2 font-bold text-dark-text/50">%</span>
              </div>
              <PrimaryButton @click="setMacro('fats')" type="button"
                class="col-span-3 sm:col-span-2 flex justify-center">
                Calculate
                Fats</PrimaryButton>
            </div>

            <p class="text-xs">
              * It is recommended that Fats make up 20% to 35% of total daily calories. <br>
              Formula: (Calorie Goal) x (Desired Fat Percentage/100) / 9 = Daily Fat in
              Grams.
            </p>
          </div>
        </template>
      </CollapsableFolder>
    </div>


    <form @submit.prevent="updateAccount" class="my-3">
      <div class="flex flex-col space-y-2">
        <div class="flex space-x-4">
          <Checkbox name="trackMacros" class="h-6 w-6 group-hover:text-accent" v-model:checked="form.trackMacros"
            :checked="Boolean(form.trackMacros)" />
          <p>Track Macros</p>
        </div>

        <p>* Setting a macro to 0 will remove it from tracking.</p>

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