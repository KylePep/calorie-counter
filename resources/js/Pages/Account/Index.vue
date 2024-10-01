<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { data } from "autoprefixer";
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

const getDayOfWeek = (date, mod) => {
  let localDate = new Date(date); // Ensure the date is converted correctly.

  let newDay = localDate.getDay();

  if (mod) {
    let dayDifference = 6 - mod
    newDay -= dayDifference;
    if (newDay < 0) {
      newDay += 7;
    }
  }

  return daysOfWeek[newDay]; // Map the number to the day name.
};

const calorieDays = ref(props.calorieDays);
const totalDays = 7;

const combinedDays = computed(() => {
  const placeholdersCount = totalDays - calorieDays.value.length;
  const placeholders = Array.from({ length: placeholdersCount }, () => ({ isPlaceholder: true }));

  return [...placeholders, ...calorieDays.value];
});



const editGoalEnable = ref(false);

const goal = computed(() => props.account?.goal ?? 2000);

const form = useForm({
  goal: goal.value,
});



const createOrUpdateAccount = () => {
  const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  const data = {
    gender: 'Male',
    weight: 160,
    height: 177.8,
    age: 25,
    activity: '1.55',
    timezone: timezone,
  }

  form.post(route('account.store', data), {
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
  const scrollContainer = document.getElementById('scrollContainer')
  if (scrollContainer) {
    scrollContainer.scrollLeft = 1000
  }

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

        <!-- <section>
          <div v-for="calorieDay in calorieDays" :key="calorieDay.id">
            {{ new Date(calorieDay.created_at) }}
          </div>
        </section> -->

        <section v-if="props.account" class="text-center">
          <h1>History</h1>
          <div>
            Past 7 days of history
          </div>
          <div>
            Calorie Progress 13993 : 14000
          </div>
          <div v-if="calorieDays?.length" id="scrollContainer"
            class="flex  gap-1  min-h-40 p-2 text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap snap-x">


            <div v-for="(day, index) in combinedDays" :key="index"
              class="min-h-40 min-w-40 bg-gray-300 p-3 justify-between m-1 scroll-ml-1 snap-start rounded">

              <template v-if="day.isPlaceholder">
                <!-- For placeholders, calculate the day based on their index and the last real day -->
                <p class="text-wrap">
                  Day: {{ getDayOfWeek(calorieDays[0].created_at, index) }}
                  <br>
                  No results to show
                </p>
              </template>
              <template v-else>
                <!-- For real entries, just convert the existing created_at date -->
                <p>Day: {{ getDayOfWeek(day.created_at) }}</p>
                <h2>Calories: {{ day.count }}</h2>
              </template>

            </div>

          </div>

        </section>

      </div>
    </div>
  </GlobalLayout>
</template>