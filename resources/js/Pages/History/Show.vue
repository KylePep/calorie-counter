<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "@/Components/FoodComponents/CalorieHistory.vue";
import { Head } from "@inertiajs/vue3";
import NewDay from "./Partials/NewDay.vue";
import Side from "@/Components/Displays/Side.vue";
import SearchBar from "./Partials/SearchBar.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import { onMounted, ref, watch } from "vue";

const props = defineProps(['account', 'calorieDays', 'results',]);

const displayMode = ref(sessionStorage.getItem('displayMode') || 'list');

watch(displayMode, (newValue) => {
  sessionStorage.setItem('displayMode', newValue);
});

onMounted(() => {
  displayMode.value = sessionStorage.getItem('displayMode') || 'list';
});

</script>


<template>

  <Head title="History">
    <meta type="description" content="Calorie History" head-key="Food">
  </Head>

  <GlobalLayout heroImage="/assets/calorieHistory.jpeg" heroHeight="50">

    <template #header>
      Your History
    </template>

    <section>
      <SearchBar :results="results" :displayMode="displayMode" />
    </section>

    <section>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-white rounded border border-light shadow-lg p-3">
        <div class="col-span-2 font-bold ">
          Display Modes:
        </div>
        <PrimaryButton @click="displayMode = 'list'" class="flex justify-center"> <span
            class="hidden sm:block">List</span>
          <i class="ms-2 mdi mdi-card-text"></i>
        </PrimaryButton>
        <PrimaryButton @click="displayMode = 'bar'" class="flex justify-center"><span class="hidden sm:block">Progress
            Bar</span> <i class="ms-2 mdi mdi-poll rotate-90"></i>
        </PrimaryButton>
      </div>
    </section>

    <section v-if="props.account" class="sm:hidden">
      <NewDay />
    </section>


    <section v-if="props.account" class="min-h-screen">
      <div v-for="calorieDay, index in calorieDays" :key="calorieDay.id">
        <CalorieHistory :timeZone="account.timeZone" :calorieDay="calorieDay" :displayMode="displayMode"
          :index="index" />
      </div>
    </section>

    <template #rightSide>
      <Side v-if="props.account" side="right">
        <NewDay />
      </Side>
    </template>

  </GlobalLayout>
</template>