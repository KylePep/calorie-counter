<script setup>
import CalorieCalculator from "@/Components/CalorieCalculator.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  }
});
</script>


<template>

  <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Calculator">

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calculator</h2>
    </template>

    <div class="flex justify-center max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

      <section class="space-y-6 text-center text-black/75">
        <CalorieCalculator />
      </section>

    </div>

    <template #side>
      <div class=" lg:border-s border-black/25 space-y-3 px-12 text-sm">

        <h1 class=" font-bold">This calculator uses the Mifflin-St Jeor formula</h1>

        <p>
          Females: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) – 161

        </p>
        <p>
          Males: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) + 5
        </p>
        <div class="">
          <h2 class="">
            Multiply by scale factor for activity level:

          </h2>
          <ul class="">
            <li>
              Sedentary *1.2

            </li>
            <li>
              Lightly active *1.375


            </li>
            <li>
              Moderately active *1.55

            </li>
            <li>
              Active *1.725

            </li>
            <li>
              Very active *1.9

            </li>
          </ul>

        </div>
      </div>
    </template>
  </GlobalLayout>



</template>


<style lang="scss" scoped></style>