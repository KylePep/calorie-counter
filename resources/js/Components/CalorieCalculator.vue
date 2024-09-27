<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";

const props = defineProps({
  account: {
    type: Object,
  }
})

const result = reactive({})

const form = useForm({
  gender: props.account.gender || 'Male',
  weight: props.account.weight || 160,
  heightFeet: Math.floor(props.account.height / 2.54 / 12) || 5,
  heightInches: props.account.height / 2.54 % 12 || 10,
  height: props.account.height,
  age: props.account.age || 25,
  activity: props.account.activity || '1.55',
  genderMod: '-161',
  goal: props.account.goal || 2000,
});

const calculateResult = () => {
  const height = ((form.heightFeet * 12) +
    form.heightInches) * 2.54
  console.log(height, form.heightFeet, form.heightInches)
  const weight = form.weight / 2.205
  const genderMod = form.gender == 'Female' ? -161 : +5

  const heightResult = 6.25 * height
  const weightResult = 10 * weight
  const ageResult = 5 * form.age

  const basicResult = weightResult + heightResult - ageResult + genderMod

  const activityResult = Math.round(basicResult * form.activity)

  form.height = height
  form.goal = activityResult

  result.value = activityResult
}

const updateAccount = () => {
  form.post(route('account.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log(errors); // Log validation errors
    },
  });
};

</script>


<template>
  {{ props.account.gender + ',' + props.account.weight }}

  <form @submit.prevent="updateAccount" id="calorie">
    <div class="space-y-3">
      <div>
        <h2 class="text-2xl font-semibold leading-7 text-gray-900">Calorie Calculator</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">This Calculator will calculate your basal metabolic rate (BMR)
        </p>

      </div>


      <div class="pb-12">

        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-6">
            <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Age</label>
            <div class="mt-2 relative">
              <input v-model.number="form.age" type="number" name="age" id="age" placeholder="ages 15 - 80"
                inputmode="numeric" pattern="^[0-9]*$" min="15" max="80"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 text-center">
              <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Age</span>
            </div>
          </div>

          <fieldset class="sm:col-span-6">
            <legend class="text-sm font-semibold leading-6 text-gray-900">Gender</legend>
            <div class="flex justify-around">
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
          </fieldset>

          <div class="sm:col-span-6">
            <label for="height-feet" class="block text-sm font-medium leading-6 text-gray-900">Height </label>
            <div class="grid grid-cols-2">
              <div class="mt-2 relative">
                <input v-model.number="form.heightFeet" type="number" name="height-feet" id="height-feet"
                  inputmode="numeric" min="0" max="11"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-center">
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Feet</span>

              </div>
              <div class="mt-2 relative">
                <input v-model.number="form.heightInches" type="number" name="height-inches" id="height-inches"
                  inputmode="numeric" min="0" max="11"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-center">
                <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Inches</span>

              </div>

            </div>
          </div>

          <div class="sm:col-span-6">
            <label for="weight" class="block text-sm font-medium leading-6 text-gray-900">Weight</label>
            <div class="mt-2 relative">
              <input v-model.number="form.weight" id="weight" name="weight" type="number" inputmode="numeric"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-center">
              <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Pounds</span>
            </div>

          </div>

          <div class="sm:col-span-6">
            <label for="activity" class="block text-sm font-medium leading-6 text-gray-900">Activity Level</label>
            <div class="mt-2">
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

        </div>
      </div>



    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button @click="calculateResult()" type="button"
        class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Calculate</button>
    </div>
  </form>

  <div>
    <div class="py-3">
      <h3 class="text-xl font-bold mb-3">Result:
        <span v-if="result.value">{{ Math.round(result.value) }}
          Calories <button type="submit" form="calorie" v-if="$page.props.auth.user"
            :title="`Set ${Math.round(result.value)} as calorie goal.`"
            class="ms-4 text-sm mdi mdi-plus-thick bg-gray-600 hover:bg-gray-500  rounded-full px-3 py-1 text-white">
            Set Goal</button>
        </span><span v-else>Pending</span>
      </h3>
    </div>
  </div>

</template>


<style lang="scss" scoped></style>