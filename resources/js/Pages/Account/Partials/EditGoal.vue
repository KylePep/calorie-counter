<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import NumberInput from "@/Components/Form/NumberInput.vue";


const props = defineProps(['account']);

const account = computed(() => props.account);

const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);
// const height = computed(() => props.account.height);

const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

const form = useForm({
  goal: account.value?.goal || 2000,
  goalModifier: account.value?.goalModifier || 100,
  bmr: account.value?.bmr || 2000,
  gender: account.value?.gender || 'Male',
  weight: account.value?.weight || 160,
  height: account.value?.height || 177.8,
  heightFeet: heightFeet.value || 5,
  heightInches: heightInches.value || 10,
  age: account.value?.age || 25,
  activity: account.value?.activity || '1.55',
  timezone: account.value?.timezone || timezone,
});



const createOrUpdateAccount = () => {
  form.goal = Math.round(form.bmr * (form.goalModifier * .01))

  form.post(route('account.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log(errors);
    },
  });
};

const updateAccount = () => {
  form.goal = Math.round(form.bmr * (form.goalModifier * .01))

  form.put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success('Goal updated')
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

</script>


<template>

  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">

    <div v-if="!account?.goal" class="max-w-xl">


      <div class="max-w-xl my-3">
        <form @submit.prevent="createOrUpdateAccount" class="grid grid-cols-2 gap-3 justify-start">

          <div class="flex flex-col">
            <h1 class="font-bold">
              Set Basal Metabolic Rate:
            </h1>
            <NumberInput v-model.number="form.bmr" type="number" name="bmr" id="bmr" placeholder="2000"
              inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" class="py-1" />
          </div>

          <div class="flex flex-col">
            <h1 class="font-bold">
              Set Goal Modifier:
            </h1>
            <div class="relative">
              <NumberInput v-model.number="form.goalModifier" type="number" name="goalModifier" id="goalModifier"
                placeholder="100" inputmode="numeric" pattern="^[0-9]*$" min="50" max="500" class="w-full py-1" />
              <span class="absolute top-0 right-0 px-4 py-1 font-bold text-neutral/75">%</span>
            </div>
          </div>

          <div class="col-span-2 font-bold">
            Goal: {{ Math.round(form.bmr * (form.goalModifier * .01)) }}
          </div>
          <div class=" col-span-2 space-y-3">
            <PrimaryButton>Create</PrimaryButton>
            <div class="flex space-x-2">
              <p>or</p>
              <a type="button" :href="route('calculator')">Calculate Goal
              </a>
            </div>
          </div>

        </form>
      </div>
    </div>

    <div v-else class="max-w-xl">
      <h1 class="font-bold">
        Current Calorie Goal:
      </h1>

      <div class="max-w-xl my-3">
        <form @submit.prevent="updateAccount" id="updateAccount" class="grid grid-cols-2 gap-3 justify-start ">

          <div class="flex flex-col">
            <h1>BMR</h1>
            <NumberInput v-model.number="form.bmr" class="py-1" type="number" name="bmr" id="bmr" placeholder="2000"
              inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" />
          </div>

          <div class="flex flex-col">
            <h1>Goal Modifier</h1>
            <NumberInput v-model.number="form.goalModifier" type="number" name="goalModifier" id="goalModifier"
              placeholder="2000" inputmode="numeric" pattern="^[0-9]*$" min="50" max="500" class="py-1" />
          </div>

          <div class="col-span-2 font-bold">
            Goal: {{ Math.round(form.bmr * (form.goalModifier * .01)) }}
          </div>



          <div class="col-span-2 space-y-3">
            <PrimaryButton type="submit" form="updateAccount">
              Update
            </PrimaryButton>

            <div class="flex space-x-2">
              <p>or</p>
              <a type="button" class=" " :href="route('calculator')">Recalculate
              </a>
            </div>
          </div>
        </form>
      </div>

    </div>


  </div>
</template>