<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
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

const canSetGoal = ref(false);

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
  goalModifier: 99,
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
    // preserveScroll: true,
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

  <div class="bg-main border-2 border-light rounded shadow-xl p-4 sm:p-12 ">

    <form @submit.prevent="createOrUpdateAccount" id="calorie" class="text-center mb-4">
      <div class="space-y-2">
        <div>
          <h2 class="text-2xl font-semibold leading-7 text-dark-text mb-2">Calculate your basal metabolic rate (BMR)
          </h2>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">

          <section class="grid grid-cols-2 gap-x-2 gap-y-4 ">

            <div class="col-span-2">
              <InputLabel for="age" value="Age" />
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.age" type="number" name="age" id="age" placeholder="ages 15 - 80"
                  inputmode="numeric" pattern="^[0-9]*$" min="15" max="80" class="w-full text-center"></NumberInput>
                <!-- <span class="absolute top-0 right-0 py-1.5 px-5 font-bold text-black/50">Age</span> -->
              </div>
            </div>

            <fieldset class="col-span-2">
              <legend class="text-sm font-semibold leading-6 text-dark-text">Gender</legend>
              <div class="flex justify-around h-full ">
                <div class="flex items-center gap-x-3">
                  <input v-model="form.gender" id="gender-male" name="gender" type="radio" value="Male"
                    class="h-4 w-4 text-dark-text focus:ring-accent" />
                  <InputLabel for="gender-male" value="Male" />
                </div>
                <div class="flex items-center gap-x-3">
                  <input v-model="form.gender" id="gender-female" name="gender" type="radio" value="Female"
                    class="h-4 w-4 text-dark-text focus:ring-accent" />
                  <InputLabel for="gender-female" value="Female" />
                </div>
              </div>
            </fieldset>

            <div class="col-span-2">
              <InputLabel for="height-feet" value="Height" />
              <div class="grid grid-cols-2 gap-2">
                <div class="mt-2 relative">
                  <NumberInput v-model.number="form.heightFeet" type="number" name="height-feet" id="height-feet"
                    inputmode="numeric" min="0" max="11" class="w-full text-start"></NumberInput>
                  <span class="absolute top-1 right-0 py-1.5 px-5 font-bold text-black/50 text-sm">Feet</span>

                </div>
                <div class="mt-2 relative">
                  <NumberInput v-model.number="form.heightInches" type="number" name="height-inches" id="height-inches"
                    inputmode="numeric" min="0" max="11" class="w-full text-start">
                  </NumberInput>
                  <span class="absolute top-1 right-0 py-1.5 px-5 font-bold text-black/50 text-sm">Inches</span>

                </div>

              </div>
            </div>

            <div class="col-span-2">
              <InputLabel for="weight" value="Weight" />
              <div class="mt-2 relative">
                <NumberInput v-model.number="form.weight" id="weight" name="weight" type="number" inputmode="numeric"
                  class=" w-full text-center">
                </NumberInput>
                <span class="absolute top-1 right-0 py-1.5 px-5 font-bold text-black/50 text-sm">Pounds</span>
              </div>

            </div>

            <div class="col-span-2">

              <InputLabel for="activity" value="Activity Level" />
              <div class="mt-2">
                <select v-model="form.activity" id="activity" name="activity"
                  class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
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

          </section>

          <div class="relative h-40 sm:h-full">

            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
              enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
              leave-to-class="opacity-0">
              <section v-if="result.value"
                class="absolute h-full w-full grid grid-cols-1 grid-rows-5 gap-y-4 mt-3 sm:mt-0">
                <div class="relative bg-light block">

                  <h3
                    class="absolute flex items-center justify-center w-full min-h-8 h-full bg-light text-dark-text text-xl font-bold">
                    BMR: {{ Math.round(result.value) }} Calories
                  </h3>
                </div>

                <button type="button" class="flex justify-between items-center text-sm rounded px-4"
                  :class="form.goalModifier == 100 ? 'border border-accent' : 'border border-light'"
                  @click="form.goalModifier = 100, canSetGoal = true" value=100>
                  <span>{{ Math.round(result.value) }}</span>
                  100% Maintain Weight
                </button>

                <button type="button" class="flex justify-between items-center text-sm rounded px-4"
                  :class="form.goalModifier == 90 ? 'border border-accent' : 'border border-light'"
                  @click="form.goalModifier = 90, canSetGoal = true" value=90>
                  <span>{{ Math.round(result.value * .9) }}</span>
                  90% Mild Weight Loss 0.5lb/week
                </button>

                <button type="button" class="flex justify-between items-center text-sm rounded px-4"
                  :class="form.goalModifier == 80 ? 'border border-accent' : 'border border-light'"
                  @click="form.goalModifier = 80, canSetGoal = true" value=80>
                  <span>{{ Math.round(result.value * .8) }}</span>
                  80% Weight Loss 1lb/week
                </button>

                <button type="button" class="flex justify-between items-center text-sm rounded px-4"
                  :class="form.goalModifier == 61 ? 'border border-accent' : 'border border-light'"
                  @click="form.goalModifier = 61, canSetGoal = true" value=61>
                  <span>{{ Math.round(result.value * .61) }}</span>
                  61% Extreme Weight Loss 2lb/week
                </button>

              </section>
              <section v-else class="absolute h-full w-full rounded border border-light flex-1 py-2 space-y-4">
                <p><strong>Exercise:</strong> 15-30 minutes of elevated heart rate activity.</p>
                <p><strong>Intense exercise:</strong> 45-120 minutes of elevated heart rate activity</p>
                <p><strong>Very intense exercise:</strong> 2+ hours of elevated heart rate activity</p>
              </section>

            </Transition>
          </div>


        </div>
      </div>

    </form>

    <div class="relative h-10 sm:h-20">
      <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <section v-if="result.value && canSetGoal"
          class="absolute flex justify-center items-center w-full bg-light text-2xl sm:text-4xl font-bold text-dark-text h-10 sm:h-20 px-4">
          Goal: {{ Math.round(result.value * (form.goalModifier * .01)) }}
        </section>
      </Transition>
    </div>


    <div class="flex flex justify-end items-center space-x-8 mt-8">

      <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <PrimaryButton type="submit" form="calorie" v-if="$page.props.auth.user && result.value && canSetGoal">
          Set Goal <i class="ms-2 mdi mdi-checkbox-marked-circle-plus-outline"></i> </PrimaryButton>
      </Transition>

      <PrimaryButton @click="calculateResult()" type="button">
        Calculate</PrimaryButton>
    </div>
  </div>

</template>