<script setup></script>


<template>
  <div class="relative border-b-4 border-neutral-text w-48 mx-auto mb-10">
    <h2 class="absolute inset-x-0 -top-3 mx-8 text-neutral-text text-center font-bold bg-page"> FEATURE #1
    </h2>
  </div>

  <h3 class="capitalize text-neutral-text text-3xl font-bold">Powered By the usda database</h3>
  <h4 class="py-1 text-neutral-text text-sm">CalorieCalculator uses the usda's database to get accurate diet information
  </h4>
  <div loading="lazy" class="border-2 border-light shadow-xl rounded h-52 sm:h-96 mt-4" :style="{
    backgroundImage: `url(/assets/usdaDesktop.png)`,
    backgroundSize: '190%',
    backgroundPosition: '37% 80%',
    backgroundRepeat: 'no-repeat'
  }">
  </div>
</template>