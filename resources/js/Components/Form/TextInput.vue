<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);
</script>

<template>
    <input class="border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm" v-model="model"
        ref="input" />
</template>
