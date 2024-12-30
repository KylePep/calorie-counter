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
  const percent = Math.round((goodDays / validDays) * 100)
  return { goodDays: goodDays, validDays: validDays, percent: percent };
});

const macros = computed(() => {
  return Object.fromEntries(
    Object.entries(props.account.macros).filter(([key, value]) => value > 0)
  );
});

const calorieMacroStatus = computed(() => {
  if (!props.account.trackMacros || !props.account.macros) return
  let goodDays = { protein: 0, carbohydrates: 0, fats: 0 };
  let validDays = 0;
  const macroGoals = props.account.macros

  props.calorieDays.forEach(cd => {
    if (cd.count != 0) {
      validDays++;

      const totalMacros = { protein: 0, carbohydrates: 0, fats: 0 }
      cd.food_items.forEach((fi) => {
        totalMacros.protein += fi.protein
        totalMacros.carbohydrates += fi.carbohydrates
        totalMacros.fats += fi.fats
      });
      if (totalMacros.protein >= macroGoals.protein) goodDays.protein++;
      if (totalMacros.carbohydrates >= macroGoals.carbohydrates) goodDays.carbohydrates++;
      if (totalMacros.fats >= macroGoals.fats) goodDays.fats++;
    };
  });
  const percent = {
    protein: Math.round((goodDays.protein / validDays) * 100),
    carbohydrates: Math.round((goodDays.carbohydrates / validDays) * 100),
    fats: Math.round((goodDays.fats / validDays) * 100)
  }

  return { goodDays: goodDays, validDays: validDays, percent: percent };
});

function resultReadout(percent) {
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
};

function macroClass(index) {
  return {
    protein: 'bg-accent/50',
    carbohydrates: 'bg-accent-dark/50',
    fats: 'bg-accent-light/50'
  }[index]
};

</script>


<template>

  <div class="text-neutral-text p-4 lg:p-0">

    <h1 class="flex justify-between text-lg lg:text-2xl font-bold mb-3 bg-light px-2 py-1 rounded">

      <div>
        {{ pageProps.auth.user.name }}
      </div>
    </h1>

    <div class="p-2 border border-light rounded space-y-2">

      <div class="flex justify-between">

        <div class="font-bold">
          Goal:
          <span class="font-normal">{{ account.goal }}cal</span>
        </div>

        <div class="font-bold">
          BMR:
          <span class="font-normal">{{ account.bmr }}cal</span>
        </div>
      </div>

      <div class="font-bold text-center">
        Weight:
        <span class="font-normal">{{ account.weight }}lbs</span>
      </div>

      <div>
        <div class="font-bold">
          Day Results:
        </div>

        <div class="relative bg-white h-6">

          <div class=" bg-special/50 absolute h-full rounded-md"
            :style="{ width: `${Math.min(calorieDaysStatus.percent, 100)}%` }">
          </div>


          <div
            class="absolute w-full h-full grid grid-cols-6 text-neutral-text border border-light rounded-md py-1 px-3 text-xs">

            <span class="text-start font-bold text-dark-text col-span-4 sm:col-span-2">
              <p>{{ calorieDaysStatus.percent }} %</p>
            </span>

            <span class="hidden sm:block text-center font-bold text-dark-text col-span-2 ">
              <p>{{ calorieDaysStatus.goodDays }} Good days</p>
            </span>

            <span class=" col-span-2 sm:col-span-2 text-end font-bold text-dark-text">
              <p>{{ calorieDaysStatus.validDays }} days</p>
            </span>
          </div>

        </div>
        <div class="text-sm">
          {{ resultReadout(calorieDaysStatus.percent) }}
        </div>
      </div>

      <div v-if="account.trackMacros">
        <div class="font-bold">
          Macro Results:
        </div>
        <div v-for="macro, index in macros" :key="index" class="relative bg-white h-12">

          <div class="absolute h-1/2 rounded-md" :class="macroClass(index)"
            :style="{ width: `${calorieMacroStatus.percent[index]}%` }">
          </div>


          <div
            class="absolute w-full h-1/2 grid grid-cols-6 text-neutral-text border border-light rounded-md py-1 px-3 text-xs">

            <span class="text-start font-bold text-dark-text col-span-4 sm:col-span-2">
              <p>{{ calorieMacroStatus.percent[index] }} %</p>
            </span>

            <span class="hidden sm:block text-center font-bold text-dark-text col-span-2 ">
              <p>{{ calorieMacroStatus.goodDays[index] }} good days</p>
            </span>

            <span class=" col-span-2 sm:col-span-2 text-end font-bold text-dark-text">
              <p>{{ calorieMacroStatus.validDays }} days</p>
            </span>
          </div>

          <div class="absolute top-6 text-sm bg-main w-full pb-1">
            {{ resultReadout(calorieMacroStatus.percent[index]) }}
          </div>

        </div>
      </div>

      <div class="font-bold">
        Carrots:
        <span class="font-normal">{{ carrotStatus.complete }} | {{ carrotStatus.incomplete }}</span>
      </div>

    </div>



  </div>

</template>


<style lang="scss" scoped></style>