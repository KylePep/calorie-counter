<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";

const props = defineProps(['account']);

const account = computed(() => props.account);

const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);
const displayActivity = computed(() => {
  return {
    1: "Basal Metabolic Rate",
    1.2: "Sedentary: little or no exercise",
    1.375: "Exercise 1-3 times/week",
    1.465: "Exercise 4-5 times/week",
    1.55: "Daily exercise or intense exercise 3-4 times/week",
    1.725: "Intense exercise 6-7 times/week",
    1.9: "Very intense exercise daily, or physical job",
  }[props.account.activity]
});

const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

const edit = ref(false);

const form = useForm({
  goal: account.value?.goal,
  goalModifier: account.value?.goalModifier,
  bmr: account.value?.bmr,
  gender: account.value?.gender || 'Male',
  weight: account.value?.weight || 160,
  height: account.value?.height || 177.8,
  heightFeet: heightFeet.value || 5,
  heightInches: heightInches.value || 10,
  age: account.value?.age || 25,
  activity: account.value?.activity || '1.55',
  timezone: account.value?.timezone || timezone,
});

const updateAccount = () => {

  edit.value = false

  form.transform((data) => ({
    ...data,
    height: ((data.heightFeet * 12) + data.heightInches) * 2.54
  }))
    .put(route('account.update', props.account.id), {
      preserveScroll: true,
      onSuccess: () => {
        Pop.success('Stats updated')
      },
      onError: (errors) => {
        console.log(errors);
      },
    });
};
</script>


<template>
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">

    <div class="space-y-3">

      <div class="grid grid-cols-5">
        <h1 class="font-bold mb-3 col-span-5 lg:col-span-3">Stats</h1>

        <PrimaryButton v-if="!edit" @click="edit = true" class="col-span-3 lg:col-span-2 justify-center">
          Change Stats
        </PrimaryButton>

        <SecondaryButton v-else @click="edit = false" class="col-span-3 lg:col-span-2 justify-center">
          Cancel
        </SecondaryButton>
      </div>

      <div v-if="!edit" class="max-w-xl my-3">
        <div class="max-w-xl">
          <div class="grid grid-cols-4 gap-3 my-3">
            <div>
              <InputLabel for="age" value="Age" />
              <p>{{ props.account.age }}</p>
            </div>

            <div>
              <InputLabel for="weight" value="Weight" />
              <p>{{ props.account.weight }}</p>
            </div>

            <div class="col-span-2">
              <div class="text-sm font-semibold leading-6 text-gray-900">Gender</div>
              <p>{{ props.account.gender }}</p>
            </div>

            <div class="col-span-4">
              <InputLabel for="height" value="Height" />
              <div class="grid grid-cols-2 gap-3">
                <div class="mt-2">
                  <p>{{ heightFeet }}<span class="py-1.5 px-5 font-bold text-black/50">Feet</span></p>

                </div>
                <div class="mt-2">
                  <p>{{ heightInches }}<span class="py-1.5 px-5 font-bold text-black/50">Inches</span></p>

                </div>
              </div>
            </div>



            <div class="col-span-4">
              <InputLabel for="activity" value="Activity Level" />
              <p>{{ displayActivity }}</p>
            </div>

          </div>
        </div>
      </div>

      <form v-else @submit.prevent="updateAccount" class="max-w-xl">
        <div class="grid grid-cols-4 gap-3 my-3">
          <div>
            <InputLabel for="age" value="Age" />
            <NumberInput v-model.number="form.age" class="w-full py-1" type="number" name="age" id="age"
              placeholder="25" inputmode="numeric" pattern="^[0-9]*$" min="15" max="80" />
          </div>

          <div>
            <InputLabel for="weight" value="Weight" />
            <NumberInput v-model.number="form.weight" class="w-full py-1" type="number" name="weight" id="weight"
              placeholder="25" inputmode="numeric" pattern="^[0-9]*$" min="80" max="500" />
          </div>

          <div class="col-span-2">
            <legend class="text-sm font-semibold leading-6 text-gray-900">Gender</legend>
            <div class="flex justify-start gap-x-3">
              <div class="flex items-center gap-x-3">
                <input v-model="form.gender" id="gender-male" name="gender" type="radio" value="Male"
                  class="h-4 w-4 border-gray-300 text-gray-600 focus:ring-gray-600" />
                <label for="gender-male" class="block text-sm font-medium leading-6 text-gray-900">Male</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input v-model="form.gender" id="gender-female" name="gender" type="radio" value="Female"
                  class="h-4 w-4 border-gray-300 text-gray-600 focus:ring-gray-600" />
                <label for="gender-female" class="block text-sm font-medium leading-6 text-gray-900">Female</label>
              </div>
            </div>
          </div>

          <div class="col-span-4">
            <InputLabel for="height" value="Height" />
            <div class="grid grid-cols-2 gap-3">
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.heightFeet" type="number" name="height-feet" id="height-feet"
                  inputmode="numeric" min="0" max="11" class="w-full py-1.5" />
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Feet</span>
              </div>
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.heightInches" type="number" name="height-inches" id="height-inches"
                  inputmode="numeric" min="0" max="11" class="w-full py-1.5" />
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Inches</span>
              </div>
            </div>
          </div>



          <div class="col-span-4">
            <InputLabel for="activity" value="Activity Level" />
            <select v-model="form.activity" id="activity" name="activity"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              <option value=1>Basal Metabolic Rate</option>
              <option value=1.2>Sedentary: little or no exercise</option>
              <option value=1.375>Exercise 1-3 times/week</option>
              <option value=1.465>Exercise 4-5 times/week</option>
              <option value=1.55>Daily exercise or intense exercise 3-4 times/week</option>
              <option value=1.725>Intense exercise 6-7 times/week</option>
              <option value=1.9>Very intense exercise daily, or physical job</option>
            </select>
          </div>

        </div>

        <PrimaryButton>update</PrimaryButton>
      </form>
    </div>
  </div>

</template>
