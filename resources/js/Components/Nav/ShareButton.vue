<script setup>
const appUrl = window.location.origin;
const data = {
  url: appUrl,
  text: 'calorie counter app',
  title: 'Calorie Counter'
}
const share = () => {

  navigator.share(data)
}
</script>


<template>
  <button @click="share" class="mdi mdi-share-variant hover:text-accent-light duration-300 "></button>
</template>


<style lang="scss" scoped></style>