<script setup>
import CalorieCalculator from "@/Components/CalorieCalculator.vue";
import { Head } from '@inertiajs/vue3';

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

  <Head title="Calculate" />


  <div class="bg-gray-50 text-black/50">
    <div class="relative flex justify-center selection:bg-[#FF2D20] selection:text-white">
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

        <header class="grid grid-cols-2 gap-2 py-10 ">
          <div class="text-2xl font-bold text-black/75">
            <Link href="/"
              class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] uppercase">
            Calorie Counter
            </Link>
          </div>
          <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
              class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
            Dashboard
            </Link>

            <template v-else>
              <Link :href="route('login')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
              Log in
              </Link>

              <Link v-if="canRegister" :href="route('register')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
              Register
              </Link>
              <Link v-if="canRegister" :href="route('calculator')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
              Calculate
              </Link>
            </template>

          </nav>
        </header>


      </div>
    </div>
  </div>

  <main class="mt-6 space-y-6 max-w-xl mx-auto min-h-screen text-center text-black/75">
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
  </main>

</template>


<style lang="scss" scoped></style>