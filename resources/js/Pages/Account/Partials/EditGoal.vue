<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import NumberInput from "@/Components/NumberInput.vue";


const props = defineProps({
  account: {
    type: Object,
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
  goalModifier: account.value?.goalModifier || 0,
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
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">

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

    <div v-else class="max-w-xl">
      <h1 class="font-bold">
        Current Calorie Goal:
      </h1>

      <div class="max-w-xl my-3">
        <form @submit.prevent="updateAccount" id="updateAccount" class="grid grid-cols-2 gap-3 justify-start ">

          <NumberInput v-model.number="form.goal" class="py-1" type="number" name="goal" id="goal" placeholder="2000"
            inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000" />

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


<style lang="scss" scoped></style>