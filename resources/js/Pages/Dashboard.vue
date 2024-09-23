<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from "vue";


const foodItems = [1, 1, 2, 1, 1, 2, 2, 2, 1, 1, 2, 1, 2]

const calorieCount = ref(0)

</script>

<template>

    <Head title="Dashboard">
        <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
    </Head>

    <GlobalLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p>
                    Here's how it's going {{ calorieCount }}
                </p>
                <div
                    class="sticky top-20 grid grid-cols-5 sm:grid-cols-10 gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                    <div v-for="index in 20" :key="index"
                        :class="index <= calorieCount ? 'bg-green-500' : 'bg-gray-300'" class="min-h-20 shadow-inner">
                        {{ index }}
                    </div>
                </div>

                <p class="mt-6">What have you eaten today?</p>

                <div class="columns-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">
                    <div @click="calorieCount += item" v-for="item, index in foodItems" :key="item"
                        :class="[item % 2 != 0 ? 'h-[10rem]' : 'h-[20rem]']"
                        class="break-inside-avoid flex justify-center w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow">
                        <img class="object-cover h-full"
                            src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt="">
                        <div>{{ item }}</div>
                    </div>
                </div>
            </div>
        </div>
    </GlobalLayout>

</template>
