<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import CalorieHistory from "@/Components/FoodComponents/CalorieHistory.vue";
import { Head } from "@inertiajs/vue3";
import NewDay from "./Partials/NewDay.vue";
import Side from "@/Components/Displays/Side.vue";
import SearchBar from "./Partials/SearchBar.vue";
import { onMounted, ref, watch } from "vue";
import DisplayMode from './Partials/DisplayMode.vue'
import WeighInHistory from "./Partials/WeighInHistory.vue";

const props = defineProps(['account', 'calorieDays', 'results', 'weighIns']);

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

    <section v-if="props.account" class="lg:hidden space-y-3">
      <NewDay />
    </section>

    <section>
      <SearchBar :results="results" :displayMode="displayMode" />
    </section>

    <section>
      <DisplayMode v-model:displayMode="displayMode" />
    </section>




    <section v-if="props.account">
      <div v-for="calorieDay, index in calorieDays" :key="calorieDay.id">
        <CalorieHistory :timeZone="account.timeZone" :calorieDay="calorieDay" :displayMode="displayMode"
          :index="index" />
      </div>
    </section>

    <template #leftSide>
      <Side v-if="props.account" side="left">
        <WeighInHistory :weighIns="props.weighIns" />
      </Side>
    </template>

    <template #rightSide>
      <Side v-if="props.account" side="right" class="hidden lg:block">
        <NewDay />
      </Side>
    </template>

  </GlobalLayout>
</template>