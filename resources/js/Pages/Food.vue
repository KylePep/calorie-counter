<script setup>
import FoodList from "@/Components/FoodList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>


<template>

  <Head title="Dashboard">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Food</h2>
    </template>

    <div class="space-y-12 max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

      <p class="text-3xl text-green-500 mx-4">
      <ul class="list-disc">
        <li>Get FoodItems created by the user</li>
        <li>Maybe get abbreviated versions of FoodDataItems were the last 10 are saved within the account</li>
        <li>Need the ability to create foodItems</li>
      </ul>
      </p>

      <section>
        <h1 class="text-xl font-bold pb-3">Your Favorite Foods</h1>
        <div class="min-h-40 border border-black/25 border-2 rounded bg-gray-300 flex">
          <div v-for="index in 3"
            class="flex flex-col justify-center text-center min-h-36 bg-gray-200 flex-1 rounded m-2">
            item
          </div>
        </div>
      </section>

      <section>
        <h1 class="text-xl font-bold pb-3">Recent Foods</h1>

        <div class="min-h-40 border border-black/25 border-2 rounded bg-gray-300 flex">
          <div v-for="index in 3"
            class="flex flex-col justify-center text-center min-h-36 bg-gray-200 flex-1 rounded m-2">
            item
          </div>
        </div>
      </section>

      <section>
        <FoodList />
      </section>


    </div>

  </GlobalLayout>
</template>


<style lang="scss" scoped></style>