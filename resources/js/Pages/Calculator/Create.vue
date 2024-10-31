<script setup>
import CalorieCalculator from "@/Pages/Calculator/Partials/CalorieCalculator.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Side from "@/Components/Displays/Side.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);

</script>


<template>

  <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Calculator">

    <template #header>
      <h2 class="font-semibold text-xl leading-tight">Calculator</h2>
    </template>

    <section>
      <CalorieCalculator :account="account" />
    </section>

    <template #rightSide>
      <Side side="right">
        <h1 class="font-bold">This calculator uses the Mifflin-St Jeor formula</h1>

        <p>
          Females: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) – 161

        </p>
        <p>
          Males: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) + 5
        </p>

        <div>
          <h2 class="mb-2 font-semibold">
            Multiply by scale factor for activity level:
          </h2>
          <ul>
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
      </Side>

    </template>
  </GlobalLayout>



</template>