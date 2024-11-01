<script setup>
import CalorieCalculator from "@/Pages/Calculator/Partials/CalorieCalculator.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Side from "@/Components/Displays/Side.vue";
import CollapsableFolder from "@/Components/Displays/CollapsableFolder.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);

</script>


<template>

  <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Calculator" heroImage="/assets/calculator.jpeg"
    heroHeight="10">

    <template #header>
      Calculator
    </template>

    <section class="mt-4 sm:mt-0">
      <CalorieCalculator :account="account" />
    </section>

    <template #leftSide>
      <Side side="left">

        <div class="w-full">

          <CollapsableFolder :state="false">
            <template #title>
              BMR Definition
            </template>

            <template #content>
              <p class="text-xs mb-5">
                Your Basal Metabolic Rate (BMR) is the number of calories you burn as your body performs basic (basal)
                life-sustaining function. Commonly also termed as Resting Metabolic Rate (RMR), which is the calories
                burned if you stayed in bed all day. In either case, many utilize the basal metabolic rate formula to
                calculate their body’s metabolism rate.
              </p>
              <p class="text-xs">
                "Basal Metabolic Rate Calculator" Garnet Health, 1 Jul. 2016, <br>
                https://www.garnethealth.org/news/basal-metabolic-rate-calculator.
              </p>
            </template>
          </CollapsableFolder>
        </div>

        <div class="w-full">


          <CollapsableFolder :state="false">
            <template #title>
              Mifflin-St Jeor formula
            </template>

            <template #content>
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
            </template>
          </CollapsableFolder>
        </div>

      </Side>

    </template>

    <template #rightSide>
      <Side side="right">

        <div class="w-full space-y-4 text-xs">

          <p>This calculation is based on widely-accepted formulas, but it is not a prescription for your health and
            nutrition. Consult with your doctor before making a change to your nutrition or diet</p>

          <p>All content presented are provided for informational and educational purposes only, and are not intended to
            approximate or replace professional medical advice, diagnosis, or treatment. Always seek the advice of your
            physician or other qualified healthcare provider with any questions you may have regarding a medical
            condition.
            Never disregard or delay seeking professional medical advice because of something you have read within the
            website
            content. If you think you may have a medical emergency, call 911 immediately.</p>
        </div>

      </Side>

    </template>
  </GlobalLayout>



</template>