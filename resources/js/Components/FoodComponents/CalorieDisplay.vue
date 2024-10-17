<script setup>
import { ref } from "vue";


const props = defineProps(['calorieGoal', 'calorieCount'])

const cellCount = ref(props.calorieGoal / 100)
const calorieCountRows = ref(Math.ceil(props.calorieGoal / 1000))

</script>

<template>

  <section class=" z-10 bg-white p-1 text-center border-4 rounded-lg border-black/25 shadow-xl"
    :class="calorieCount < calorieGoal ? 'sticky top-16' : ''">

    <div v-for="row in calorieCountRows" :key="row" class="  grid grid-rows-1 grid-flow-col gap-1 mb-1">
      <div v-for="index in 10" :key="index"
        :class="[((row - 1) * 10 + index) * 100 <= calorieCount && index + ((row - 1) * 10) <= cellCount ? 'bg-green-500 text-transparent' : 'bg-gray-300 text-black/50', index + ((row - 1) * 10) <= cellCount ? '' : 'bg-black/25 text-transparent']"
        class="min-h-10 text-sm flex flex-col justify-center duration-300">
        100
      </div>
    </div>
  </section>

  <section v-if="calorieCount > calorieGoal"
    class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25 shadow-xl">
    <div v-for="index in 40" :key="index"
      :class="[index * 50 + calorieGoal <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']"
      class="min-h-10 duration-300">
    </div>
  </section>

</template>
