<script setup>
import { ref } from "vue";


const props = defineProps(['calorieGoal', 'calorieCount'])

const cellCount = ref(props.calorieGoal / 100)
const calorieCountRows = ref(Math.ceil(props.calorieGoal / 1000))

</script>

<template>

  <section
    class=" z-10 px-1.5 py-0.5 text-center rounded ring-1 ring-white ring-inset border-2  border border-gray-300 shadow-lg bg-auto bg-gradient-to-b from-white via-gray-100 to-gray-200 "
    :class="calorieCount < calorieGoal ? 'sticky top-16' : ''">

    <div v-for="row in calorieCountRows" :key="row" class="  grid grid-rows-1 grid-flow-col gap-1 my-1">
      <div v-for="index in 10" :key="index"
        :class="[((row - 1) * 10 + index) * 100 <= calorieCount && index + ((row - 1) * 10) <= cellCount ? 'bg-green-500 border border-gray-100 text-transparent ' : 'bg-gray-300 text-transparent sm:text-black/50 border border-gray-100', index + ((row - 1) * 10) <= cellCount ? '' : 'bg-gray-400 text-transparent sm:text-transparent']"
        class="min-h-10 text-sm flex flex-col justify-center duration-300">
        100
      </div>
    </div>
  </section>

  <section v-if="calorieCount > calorieGoal"
    class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 border-double rounded-lg border-black/25 shadow-lg">
    <div v-for="index in 40" :key="index"
      :class="[index * 50 + calorieGoal <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']"
      class="min-h-10 duration-300">
    </div>
  </section>

</template>
