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

    <div class="mt-6 space-y-6 max-w-xl mx-auto min-h-screen text-center text-black/75">
      <CalorieCalculator />

      <section class="space-y-3 py-10">
        <h1 class="text-xl">This calculator uses the Mifflin-St Jeor formula</h1>

        <p>
          Females: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) – 161

        </p>
        <p>
          Males: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) + 5
        </p>
        <div class="">
          <h2 class="text-lg">
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
      </section>
    </div>
  </GlobalLayout>



</template>


<style lang="scss" scoped></style>