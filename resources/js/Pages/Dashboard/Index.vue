<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);
</script>

<template>
  <GlobalLayout head="Dashboard">

    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Dashboard</h2>
    </template>

    <div class="space-y-32 my-32">

      <div>
        Dashboard will show results, a kind of status report
      </div>
      <div>
        A link that leads to counting
      </div>
      <div>
        A portion that shows repeated food items across the last 31 days or so
      </div>
      <div>
        Show potential food items made by the community that might be suitable for your calorie goals
      </div>
      <div>
        Build a meal schedule
      </div>

    </div>

  </GlobalLayout>
</template>