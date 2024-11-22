<script setup>
const share = () => {
  const data = {
    url: import.meta.env.APP_URL,
    text: 'calorie counter app',
    title: 'Calorie Counter'
  }
  navigator.share(data)
}
</script>


<template>
  <button @click="share" class="mdi mdi-share-variant hover:text-accent-light duration-300 ">

  </button>
</template>


<style lang="scss" scoped></style>