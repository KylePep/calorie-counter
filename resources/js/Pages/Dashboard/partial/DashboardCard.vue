<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps(['account', 'calorieDays', 'carrots']);

const { props: pageProps } = usePage();

const carrotStatus = computed(() => {
  let completeCarrots = 0
  let incompleteCarrots = 0
  props.carrots.forEach(c => {
    if (c.complete) {
      completeCarrots++;
    } else incompleteCarrots++;
  });
  return { complete: completeCarrots, incomplete: incompleteCarrots }
});

const calorieDaysStatus = computed(() => {
  let goodDays = 0;
  let validDays = 0;
  props.calorieDays.forEach(cd => {
    if (cd.count != 0) {
      validDays++;
    }
    if (cd.count >= cd.goal && cd.count <= cd.bmr) {
      goodDays++;
    }
  });
  return { goodDays: goodDays, validDays: validDays };
});

const calorieReadout = computed(() => {
  const percent = Math.round((calorieDaysStatus.value.goodDays / calorieDaysStatus.value.validDays) * 100);
  let message = '';
  if (percent >= 90) {
    message = `You're doing great!`;
  } else if (percent >= 70) {
    message = `Not bad, stay focused!`;
  } else if (percent >= 50) {
    message = `Take it one meal at a time.`;
  } else {
    message = `Hang in there.`;
  }

  return message;
})

</script>


<template>

  <div class="text-neutral-text p-4 lg:p-0">

    <h1 class="flex justify-between text-lg lg:text-2xl font-bold mb-3 bg-light px-2 py-1 rounded">

      <div>
        {{ pageProps.auth.user.name }}
      </div>
    </h1>

    <div class="p-2 border border-light rounded">

      <div class="flex justify-between">

        <div>
          Weight: {{ account.weight }}lbs
        </div>
        <div>
          Goal: {{ account.goal }}cal
        </div>

        <div>
          BMR: {{ account.bmr }}cal
        </div>
      </div>

      <div>
        {{ calorieReadout }}
        {{ Math.round((calorieDaysStatus.goodDays / calorieDaysStatus.validDays) * 100) }}%
      </div>

      <div v-if="account.trackMacros">
        Macro Goals
        <div v-for="macro, index in account.macros">
          <div v-if="macro > 0">
            <span class="capitalize">{{ index }}: </span>
            <span> {{ macro }}g</span>
          </div>
        </div>
      </div>

      <div>
        <div>Carrots: {{ carrotStatus.complete }} | {{ carrotStatus.incomplete }}</div>
      </div>

    </div>



  </div>

</template>


<style lang="scss" scoped></style>