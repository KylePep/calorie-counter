<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";


const props = defineProps({
  status: {
    type: String,
  },
  account: {
    type: Object,
  }
});

const goal = computed(() => props.account?.goal ?? 2000);

const form = useForm({
  goal: goal.value,
});

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

        <section class="text-center">
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
        </section>

        <section class="text-center">
          <h1 class="text-xl">
            Current Calorie Goal:
          </h1>
          <div>
            {{ account.goal }}
          </div>
          <form @submit.prevent="updateAccount" class="pb-3 pt-12 ">
            <div class="flex flex-col space-y-6 max-w-sm mx-auto">
              <InputLabel for="goal" value="Manually Enter Goal">Manually Enter Goal</InputLabel>

              <input v-model.number="form.goal" type="number" name="goal" id="goal" placeholder="2000"
                inputmode="numeric" pattern="^[0-9]*$" min="1000" max="20000"
                class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-lg sm:leading-6 text-center">

              <PrimaryButton class=" mx-auto">Change</PrimaryButton>
            </div>

          </form>
          <p>or</p>
          <NavLink :href="route('calculator')">Recalculate</NavLink>

        </section>

        <section class="text-center">
          <h1>History</h1>
          <div>
            Past 7 days of history
          </div>
        </section>

      </div>
    </div>
  </GlobalLayout>
</template>