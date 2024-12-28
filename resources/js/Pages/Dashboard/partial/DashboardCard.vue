<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps(['account']);

const { props: pageProps } = usePage();

const heightFeet = computed(() => Math.floor((props.account?.height ?? 177.8) / 2.54 / 12) ?? 5);
const heightInches = computed(() => (props.account?.height ?? 177.8) / 2.54 % 12 ?? 10);
const displayActivity = computed(() => {
  return {
    1: "Basal Metabolic Rate",
    1.2: "Sedentary: little or no exercise",
    1.375: "Exercise 1-3 times/week",
    1.465: "Exercise 4-5 times/week",
    1.55: "Daily exercise or intense exercise 3-4 times/week",
    1.725: "Intense exercise 6-7 times/week",
    1.9: "Very intense exercise daily, or physical job",
  }[props.account.activity]
});

</script>


<template>

  <div class="text-neutral-text p-4 lg:p-8">

    <h1 class="flex justify-between text-lg lg:text-2xl font-bold mb-3 bg-light px-2 py-1 rounded">
      <div>
        {{ pageProps.auth.user.name }}
      </div>
      <div>
        age: {{ account.age }}
      </div>
    </h1>

    <div class="flex">
      <div>
        height: {{ heightFeet }}' {{ heightInches }}"
      </div>

      <div>
        weight: {{ account.weight }}
      </div>
    </div>

    <div class="flex">
      <div>
        Goal: {{ account.goal }}
      </div>

      <div>
        BMR: {{ account.bmr }}
      </div>
    </div>

    <div>
      Activity: {{ displayActivity }}
    </div>

    <div v-if="account.trackMacros">
      <div v-for="macro, index in account.macros">
        <div v-if="macro > 0">
          <span>{{ index }}:</span>
          <span> {{ macro }}</span>
        </div>
      </div>
    </div>

  </div>

</template>


<style lang="scss" scoped></style>