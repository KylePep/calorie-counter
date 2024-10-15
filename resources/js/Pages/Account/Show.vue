<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import NumberInput from "@/Components/NumberInput.vue";


const props = defineProps({
  status: {
    type: String,
  },
  account: {
    type: Object,
  },
  calorieDays: {
    type: Object
  }
});

const goal = computed(() => props.account?.goal ?? 2000);
const account = computed(() => props.account);

const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);
const height = computed(() => props.account.height);

const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

const form = useForm({
  goal: goal.value,
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

  form.post(route('account.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log(errors);
    },
  });
};

const updateAccount = () => {

  form.height = ((form.heightFeet * 12) + form.heightInches) * 2.54

  form.put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success('Goal updated + This will take effect on a new day')
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

</script>

<template>

  <GlobalLayout head="Profile">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
      <NavLink :href="route('profile.edit')">
        Edit Account
      </NavLink>
    </template>


    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

          <div v-if="!account?.goal" class="max-w-xl">
            <h1 class="font-bold">
              Create a calorie goal:
            </h1>

            <div class="max-w-xl my-3">
              <form @submit.prevent="createOrUpdateAccount" class="grid grid-cols-2 gap-3 justify-start">

                <NumberInput v-model.number="form.goal" type="number" name="goal" id="goal" placeholder="2000"
                  inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" class="py-1" />
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

          <div v-if="account?.goal" class="max-w-xl">
            <h1 class="font-bold">
              Current Calorie Goal:
            </h1>

            <div class="max-w-xl my-3">
              <form @submit.prevent="updateAccount" id="updateAccount" class="grid grid-cols-2 gap-3 justify-start ">

                <NumberInput v-model.number="form.goal" class="py-1" type="number" name="goal" id="goal"
                  placeholder="2000" inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" />

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

        <div v-if="account?.id" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

          <form @submit.prevent="updateAccount" class="max-w-xl">
            <h1 class="font-bold">Stats</h1>
            <div class="grid grid-cols-4 gap-3 my-3">
              <div>
                <InputLabel value="Age" />
                <NumberInput v-model.number="form.age" class="w-full py-1" type="number" name="age" id="age"
                  placeholder="25" inputmode="numeric" pattern="^[0-9]*$" min="15" max="80" />
              </div>

              <div>
                <InputLabel value="Weight" />
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
                <InputLabel value="Height" />
                <div class="grid grid-cols-2 gap-3">
                  <div class="mt-2 relative">
                    <NumberInput v-model.number="form.heightFeet" type="number" name="height-feet" id="height-feet"
                      inputmode="numeric" min="0" max="11" class="w-full py-1.5" />
                    <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Feet</span>
                  </div>
                  <div class="mt-2 relative">
                    <NumberInput v-model.number="form.heightInches" type="number" name="height-inches"
                      id="height-inches" inputmode="numeric" min="0" max="11" class="w-full py-1.5" />
                    <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Inches</span>
                  </div>
                </div>
              </div>



              <div class="col-span-4">
                <InputLabel value="Activity Level" />
                <select v-model="form.activity" id="activity" name="activity"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value=1>Basal Metabolic Rate</option>
                  <option value=1.2>Sedentary: little or no exercise</option>
                  <option value=1.375>Light: exercise 1-3 times/week</option>
                  <option value=1.55>Moderate: exercise 4-5 times/week</option>
                  <option value=1.725>Active: daily exercise or intense exercise 3-4 times/week</option>
                  <option value=1.9>Very Active: intense exercise 6-7 times/week</option>
                </select>
              </div>

            </div>

            <PrimaryButton>update</PrimaryButton>
          </form>
        </div>


      </div>
    </div>
  </GlobalLayout>
</template>