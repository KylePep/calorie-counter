<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { useForm } from "@inertiajs/vue3";


defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  calorieGoal: 2000,
});

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
          <h1 class="text-xl">
            Current Calorie Goal:
          </h1>
          <div>
            -- Calorie Goal --
          </div>
          <div class="flex justify-center space-x-6">
            <button>Recalculate</button>
            <div class="flex items-center">
              <InputLabel for="calorieGoal" value="CalorieGoal" class="hidden">Manually Enter Goal</InputLabel>
              <TextInput id="calorieGoal" type="text" class=" block w-full" v-model="form.name" required autofocus
                placeholder="Change Goal"></TextInput>
              <PrimaryButton class="ms-4">Update</PrimaryButton>
            </div>
          </div>
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