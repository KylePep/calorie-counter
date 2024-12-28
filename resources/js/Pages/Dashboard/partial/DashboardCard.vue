<script setup>
import { usePage } from "@inertiajs/vue3";

const props = defineProps(['account']);

const { props: pageProps } = usePage();
</script>


<template>
  <div class="mx-4 lg:mt-12 bg-accent">
    <div>
      Name: {{ pageProps.auth.user.name }}
    </div>
    <div>
      BMR: {{ account.bmr }}
    </div>


    <div>
      Goal: {{ account.goal }}
    </div>

    <div>
      Age: {{ account.age }}
    </div>

    <div>
      Gender: {{ account.gender }}
    </div>
    <div>
      height: {{ account.height }}
    </div>
    <div>
      weight: {{ account.weight }}
    </div>
    <div>
      Activity: {{ account.activity }}
    </div>
    <div>
      Macros: {{ account.trackMacros }}
    </div>
    <div v-for="macro, index in account.macros">
      {{ index }}: {{ macro }}
    </div>

  </div>
</template>


<style lang="scss" scoped></style>