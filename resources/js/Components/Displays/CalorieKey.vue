<script setup>
import CollapsableFolder from "./CollapsableFolder.vue";

</script>

<template>


  <div class="w-full">

    <CollapsableFolder :state="false">

      <template #title>
        <p>Key</p>
      </template>

      <template #content>
        <div class="text-xs grid grid-cols-1 gap-2 lg:p-4 bg-main p-2">

          <div class="flex">
            <div class="h-8 min-w-8 max-w-8 bg-neutral border border-dark"></div>
            <p class="px-2 py-1">Uncounted square</p>
          </div>



          <div class="flex">
            <div
              class="flex justify-center items-center h-8 min-w-8 max-w-8 bg-light text-dark-text/75 border border-dark">
              100</div>
            <p class="px-2 py-1">Unused square worth 100 calories.</p>
          </div>


          <div class="flex">
            <div
              class="flex justify-center items-center h-8 min-w-8 max-w-8 bg-light text-dark-text/75 border-4 border-accent-light">
              100
            </div>
            <p class="px-2 py-1">Unused square worth 100 calories, between your goal and your bmr.</p>
          </div>


          <div class="flex">
            <div class="h-8 min-w-8 max-w-8 bg-accent border border-dark"></div>
            <p class="px-2 py-1">Used square worth 100 calories.</p>
          </div>

          <div class="flex">
            <div class="h-8 min-w-8 max-w-8 bg-accent border-4 border-accent-light"></div>
            <p class="px-2 py-1">Used square worth 100 calories, between your goal and your bmr.</p>
          </div>

        </div>
      </template>

    </CollapsableFolder>
  </div>


</template>
