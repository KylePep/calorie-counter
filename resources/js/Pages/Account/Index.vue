<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";


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

const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

const editGoalEnable = ref(false);

const goal = computed(() => props.account?.goal ?? 2000);

const form = useForm({
  goal: goal.value,
});

const getDayOfWeek = (date, mod) => {
  let newDay = date;
  if (isNaN(newDay)) {
    newDay = new Date(date).getDay();
    console.log('newDate')
  }

  if (newDay + mod > 6) {
    newDay = 0;
  }
  newDay += mod;
  return daysOfWeek[newDay]
}

const createOrUpdateAccount = () => {
  const data = {
    gender: 'Male',
    weight: 160,
    height: 177.8,
    age: 25,
    activity: '1.55',
  }

  form.post(route('account.store'), data, {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log(errors);
    },
  });
};

const updateAccount = () => {
  form.put(route('account.update', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      form.goal = goal;
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

onMounted(() => {
  document.getElementById('scrollContainer').scrollLeft = 1000

})


</script>

<template>

  <GlobalLayout head="Profile">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
      <NavLink :href="route('profile.edit')">
        Edit Details
      </NavLink>
    </template>



    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

        <!-- <section class="text-center">
          <h1 class="text-xl">Stats</h1>
          <div v-if="account">
            <ul>
              <li>Age: {{ account.age }}</li>
              <li>Gender: {{ account.gender }}</li>
              <li>Height: {{ account.height }}</li>
              <li>Weight: {{ account.weight }}</li>
              <li>activity: {{ account.activity }}</li>
            </ul>
          </div>
          <div v-else>
            Please fill out stats
          </div>
        </section> -->

        <section class="text-center">
          <div v-if="account?.goal">
            <h1 class="text-xl">
              Current Calorie Goal:
            </h1>
            <div class="text-3xl">
              {{ account?.goal }}
            </div>
          </div>

          <div v-else>
            <h1 class="text-xl">
              Create a calorie goal:
            </h1>

            <Link :href="route('calculator')" class="block mt-6">Calculate goal</Link>
            <p>or</p>
            <form @submit.prevent="createOrUpdateAccount" class="pb-3 mt-3 ">
              <div class="flex flex-col space-y-6 max-w-sm mx-auto">
                <div>

                  <InputLabel for="goal" value="Enter manually" class="mb-3">Enter manually</InputLabel>

                  <input v-model.number="form.goal" type="number" name="goal" id="goal" placeholder="2000"
                    inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000"
                    class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-lg sm:leading-6 text-center">
                </div>

                <PrimaryButton class=" mx-auto">Save</PrimaryButton>
              </div>

            </form>


          </div>

          <button v-if="account?.goal" @click="editGoalEnable = !editGoalEnable"
            class="items-center px-4 py-2 bg-gray-800 hover:bg-gray-700  border border-transparent rounded-md font-semibold text-xs text-white uppercase mt-6">{{
              !editGoalEnable ? 'Change Goal?' : 'Cancel' }}</button>
          <div v-if="editGoalEnable" class="flex flex-col justify-center items-center">

            <NavLink :href="route('calculator')" class="mt-6">Recalculate</NavLink>
            <p>or</p>
            <form @submit.prevent="updateAccount" class="pb-3 mt-3 ">
              <div class="flex flex-col space-y-6 max-w-sm mx-auto">
                <div>

                  <InputLabel for="goal" value="Manually Change Goal" class="mb-3">Manually Change Goal</InputLabel>

                  <input v-model.number="form.goal" type="number" name="goal" id="goal" placeholder="2000"
                    inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000"
                    class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-lg sm:leading-6 text-center">
                </div>

                <PrimaryButton class=" mx-auto">Save</PrimaryButton>
              </div>

            </form>
          </div>


        </section>

        <section class="text-center">
          <h1>History</h1>
          <div>
            Past 7 days of history
          </div>
          <div>
            Calorie Progress 13993 : 14000
          </div>
          <div v-if="calorieDays" id="scrollContainer"
            class="flex min-h-40 p-2 text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap snap-x ">
            <div v-for="index in 7 - calorieDays.length"
              class="inline-block min-h-40 min-w-40 bg-gray-300 p-3 justify-between m-1 scroll-ml-1 snap-start rounded">
              <h1>
                {{ getDayOfWeek(calorieDays[0].created_at, index + 1) }}
              </h1>
              <p class="text-wrap">
                No results to show
              </p>
            </div>
            <div v-for="calorieDay in calorieDays" :key="calorieDay.id"
              class="inline-block min-h-40 min-w-40 bg-gray-300 p-3 justify-between m-1 scroll-ml-1 snap-start rounded">
              <h1>
                {{ getDayOfWeek(calorieDay.created_at, 0) }}
              </h1>
              <h2>
                Calories: {{ calorieDay.count }}
              </h2>
              <i class="mdi mdi-information text-xl hover:text-black/75"></i>
            </div>
          </div>

        </section>

      </div>
    </div>
  </GlobalLayout>
</template>