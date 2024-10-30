<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NumberInput from "@/Components/NumberInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { reactive, ref } from "vue";

const props = defineProps({
  account: {
    type: Object,
    default: () => null,
  }
})

const result = reactive({})

const gender = computed(() => props.account?.gender ?? 'Male');
const weight = computed(() => props.account?.weight ?? 160);
const height = computed(() => props.account?.height ?? 177.8)
const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);
const age = computed(() => props.account?.age ?? 25);
const activity = computed(() => props.account?.activity ?? '1.55');
const bmr = computed(() => props.account?.bmr ?? 2000);
const goal = computed(() => props.account?.goal ?? 2000);
const goalModifier = computed(() => props.account?.goalModifier ?? 100);

const form = useForm({
  gender: gender.value,
  weight: weight.value,
  height: height.value,
  heightFeet: heightFeet.value,
  heightInches: heightInches.value,
  age: age.value,
  activity: activity.value,
  genderMod: '-161',
  goal: goal.value,
  bmr: bmr.value,
  goalModifier: goalModifier.value,
  timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
});

const calculateResult = () => {
  const height = ((form.heightFeet * 12) +
    form.heightInches) * 2.54

  const weight = form.weight / 2.205
  const genderMod = form.gender == 'Female' ? -161 : +5

  const heightResult = 6.25 * height
  const weightResult = 10 * weight
  const ageResult = 5 * form.age

  const basicResult = weightResult + heightResult - ageResult + genderMod

  const activityResult = Math.round(basicResult * form.activity)

  form.height = height
  form.bmr = activityResult

  result.value = activityResult
}

const createOrUpdateAccount = () => {

  form.goal = Math.round(form.bmr * (form.goalModifier * .01))

  form.post(route('account.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      Pop.success('New Goal Set!')
    },
    onError: (errors) => {
      console.log(errors); // Log validation errors
    },
  });
};

</script>


<template>

  <div class="bg-main border-2 border-light rounded shadow-xl p-12">

    <form @submit.prevent="createOrUpdateAccount" id="calorie" class="text-center">
      <div class="space-y-3">
        <div>
          <h2 class="text-2xl font-semibold leading-7 text-gray-900">Calorie Calculator</h2>
          <p class="mt-1 text-sm leading-6 text-gray-600">This will calculate your basal metabolic rate (BMR)
          </p>

        </div>


        <div class="pb-12">

          <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6">
              <InputLabel for="age" value="Age" />
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.age" type="number" name="age" id="age" placeholder="ages 15 - 80"
                  inputmode="numeric" pattern="^[0-9]*$" min="15" max="80" class="w-full text-center"></NumberInput>
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Age</span>
              </div>
            </div>

            <fieldset class="sm:col-span-6">
              <legend class="text-sm font-semibold leading-6 text-gray-900">Gender</legend>
              <div class="flex justify-around">
                <div class="flex items-center gap-x-3">
                  <input v-model="form.gender" id="gender-male" name="gender" type="radio" value="Male"
                    class="h-4 w-4 text-dark focus:ring-accent" />
                  <InputLabel for="gender-male" value="Male" />
                </div>
                <div class="flex items-center gap-x-3">
                  <input v-model="form.gender" id="gender-female" name="gender" type="radio" value="Female"
                    class="h-4 w-4 text-dark focus:ring-accent" />
                  <InputLabel for="gender-female" value="Female" />
                </div>
              </div>
            </fieldset>

            <div class=" sm:col-span-6">
              <InputLabel for="height-feet" value="Height" />
              <div class="grid grid-cols-2 gap-2">
                <div class="mt-2 relative">
                  <NumberInput v-model.number="form.heightFeet" type="number" name="height-feet" id="height-feet"
                    inputmode="numeric" min="0" max="11" class="w-full text-start sm:text-center"></NumberInput>
                  <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Feet</span>

                </div>
                <div class="mt-2 relative">
                  <NumberInput v-model.number="form.heightInches" type="number" name="height-inches" id="height-inches"
                    inputmode="numeric" min="0" max="11" class="w-full text-start sm:text-center">
                  </NumberInput>
                  <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Inches</span>

                </div>

              </div>
            </div>

            <div class="sm:col-span-6">
              <InputLabel for="weight" value="Weight" />
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.weight" id="weight" name="weight" type="number" inputmode="numeric"
                  class=" w-full text-center">
                </NumberInput>
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Pounds</span>
              </div>

            </div>

            <div class="sm:col-span-6">

              <InputLabel for="activity" value="Activity Level" />
              <div class="mt-2">
                <select v-model="form.activity" id="activity" name="activity"
                  class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
                  <option value=1>Basal Metabolic Rate</option>
                  <option value=1.2>Sedentary: little or no exercise</option>
                  <option value=1.375>Light: exercise 1-3 times/week</option>
                  <option value=1.55>Moderate: exercise 4-5 times/week</option>
                  <option value=1.725>Active: daily exercise or intense exercise 3-4 times/week</option>
                  <option value=1.9>Very Active: intense exercise 6-7 times/week</option>
                </select>
              </div>
            </div>

          </div>
        </div>
      </div>

      <h3 class="flex flex-col text-center text-xl font-bold">Result:
        <div v-if="result.value" class="">{{ Math.round(result.value) }}
          Calories
          <div class="">

            <InputLabel for="goalModifier" value="Goal Modifier" />
            <div class="mt-2">
              <select v-model="form.goalModifier" id="goalModifier" name="goalModifier"
                class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
                <option value=100>{{ Math.round(result.value) }} 100% Maintain Weight</option>
                <option value=90>{{ Math.round(result.value * .9) }} 90% Mild Weight Loss 0.5lb/week</option>
                <option value=80>{{ Math.round(result.value * .8) }} 80% Weight Loss 1lb/week</option>
                <option value=61>{{ Math.round(result.value * .61) }} 61% Extreme Weight Loss 2lb/week</option>
              </select>
            </div>
          </div>
        </div>
        <span v-else class="">Pending</span>


      </h3>
    </form>



    <div class="flex flex justify-end items-center space-x-8 mt-16">

      <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <PrimaryButton type="submit" form="calorie" v-if="$page.props.auth.user && result.value">
          Set Goal <i class="ms-2 mdi mdi-checkbox-marked-circle-plus-outline"></i> </PrimaryButton>
      </Transition>

      <PrimaryButton @click="calculateResult()" type="button">
        Calculate</PrimaryButton>
    </div>
  </div>

</template>


<style lang="scss" scoped></style>