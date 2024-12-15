<script setup>

const props = defineProps(['account', 'calorieDays'])
</script>


<template>
  <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
    <h1 class="font-bold">
      Consumed Report
    </h1>
    <h2>
      Find out what kind of foods are leading to success!
    </h2>
    <div>Good days</div>
    <div>Bad days</div>
    <!-- {{ props.account }}
    {{ props.calorieDays }} -->
  </div>
</template>


<style lang="scss" scoped></style>