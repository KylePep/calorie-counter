<script setup>
import CollapsableFolder from "./CollapsableFolder.vue";

const props = defineProps(['carrots']);

</script>

<template>

  <div class="w-full">

    <CollapsableFolder>

      <template #title>
        <p> Carrots</p>
      </template>

      <template #content>
        <div v-for="carrot in props.carrots" :key="carrot.id" class="font-bold">
          {{ carrot.description }} - {{ carrot.goalPost }}
        </div>
      </template>

    </CollapsableFolder>
  </div>
</template>
