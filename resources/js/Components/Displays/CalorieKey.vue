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
        <div class=" text-xs  grid grid-cols-1  gap-2 p-4">

          <div class="grid grid-cols-3 bg-main rounded-sm border-2 border-dark py-3 ">
            <div class="m-auto h-8 w-8 bg-neutral border border-dark"></div>
            <p class="col-span-2 p-2">Uncounted square</p>
          </div>


          <div class="grid grid-cols-3 bg-main rounded-sm border-2 border-dark py-3">
            <div class="flex justify-center items-center m-auto h-8 w-8 bg-light text-dark-text/75 border border-dark">
              100</div>
            <p class="col-span-2 p-2">Unused square worth 100 calories.</p>
          </div>

          <div class="grid grid-cols-3 bg-main rounded-sm border-2 border-dark py-3">
            <div
              class="flex justify-center items-center m-auto h-8 w-8 bg-light text-dark-text/75 border-4 border-accent-yellow">
              100
            </div>
            <p class="col-span-2 p-2">Unused square worth 100 calories, between your goal and your bmr.</p>
          </div>

          <div class="grid grid-cols-3 bg-main rounded-sm border-2 border-dark py-3">
            <div class="m-auto h-8 w-8 bg-accent border border-dark"></div>
            <p class="col-span-2 p-2">Used square worth 100 calories.</p>
          </div>

          <div class="grid grid-cols-3 bg-main rounded-sm border-2 border-dark py-3">
            <div class="m-auto h-8 w-8 bg-accent border-4 border-accent-yellow"></div>
            <p class="col-span-2 p-2">Used square worth 100 calories, between your goal and your bmr.</p>
          </div>

        </div>
      </template>

    </CollapsableFolder>
  </div>


</template>
