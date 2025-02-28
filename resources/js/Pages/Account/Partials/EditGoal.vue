<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import { ref } from "vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";


const props = defineProps(['account']);

const account = computed(() => props.account);

const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);

const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

const edit = ref(false);

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

  edit.value = false;

  form.transform((data) => ({
    ...data,
    goal: Math.round(data.bmr * (data.goalModifier * .01))
  }))
    .post(route('account.store'), {
      preserveScroll: true,
      onSuccess: () => form.reset(),
      onError: (errors) => {
        console.log(errors);
      },
    });
};

const updateAccount = () => {

  edit.value = false;

  form.transform((data) => ({
    ...data,
    goal: Math.round(data.bmr * (data.goalModifier * .01))
  }))
    .put(route('account.update', props.account.id), {
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

  <div class="p-4 lg:p-8">

    <div class="space-y-3">

      <div class="grid grid-cols-5 bg-light rounded p-1">
        <h1 class="font-bold col-span-4 flex items-center ms-1">

          {{ !account?.goal ? 'No calorie goal yet' : 'Current Calorie Goal:' }} <span>{{
            props.account?.goal }}</span>
        </h1>

        <div class="flex justify-end">
          <PrimaryButton v-if="!edit" @click="edit = true" class="relative lg:block h-8 w-8 lg:h-min lg:w-full">
            <span class="hidden lg:block">{{ !account?.goal ? 'Create' : 'Change' }} Goal</span>
            <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-pencil"></span>
          </PrimaryButton>

          <SecondaryButton v-else @click="edit = false" class="relative lg:block h-8 w-8 lg:h-fit lg:w-fit">
            <span class="hidden lg:block">Cancel</span>
            <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-close-thick"></span>
          </SecondaryButton>
        </div>

        <!-- <PrimaryButton v-if="!edit" @click="edit = true" class="col-span-3 lg:col-span-1 justify-center">
          {{ !account?.goal ? 'Create' : 'Change' }} Goal

        </PrimaryButton>
        <SecondaryButton v-else @click="edit = false" class="col-span-3 lg:col-span-1 justify-center">
          Cancel
        </SecondaryButton> -->
      </div>

      <div v-if="account?.goal && !edit" class="max-w-xl my-3">
        <div class="grid grid-cols-2 gap-3 justify-start ">

          <div class="flex flex-col">
            <h1>BMR</h1>
            <p>{{ props.account.bmr }}</p>
          </div>

          <div class="flex flex-col">
            <h1>Goal Modifier</h1>
            <p>{{ props.account.goalModifier }}</p>
          </div>

        </div>
      </div>
    </div>

    <div v-if="edit">

      <div v-if="!account?.goal" class="max-w-xl">


        <div class="max-w-xl my-3">
          <form @submit.prevent="createOrUpdateAccount" class="grid grid-cols-2 gap-3 justify-start">

            <div class="flex flex-col justify-end">
              <h1 class="font-bold">
                Set Basal Metabolic Rate:
              </h1>
              <NumberInput v-model.number="form.bmr" type="number" name="bmr" id="bmr" placeholder="2000"
                inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" class="py-1" />
            </div>

            <div class="flex flex-col justify-end">
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
                placeholder="100" inputmode="numeric" pattern="^[0-9]*$" min="50" max="500" class="py-1" />
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

  </div>
</template>