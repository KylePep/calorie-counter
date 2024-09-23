<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from "vue";


const foodItems = [
    { calH: 'h-[10rem]', size: 1 },
    { calH: 'h-[20rem]', size: 2 },
    { calH: 'h-[40rem]', size: 4 },
    { calH: 'h-[10rem]', size: 1 },
    { calH: 'h-[50rem]', size: 5 },
    { calH: 'h-[20rem]', size: 2 },
    { calH: 'h-[10rem]', size: 1 },
    { calH: 'h-[10rem]', size: 1 },
]

const calorieCount = ref(0)

const calorieCountRows = ref(3)
const calorieCountCells = ref(20)

</script>

<template>

    <Head title="Dashboard">
        <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
    </Head>

    <GlobalLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="pb-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p>
                    Here's how it's going: {{ calorieCount * 100 }}
                </p>
                <div
                    class="sticky top-16 z-10 grid grid-rows-2 grid-flow-col  gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                    <div v-for="index in 20" :key="index"
                        :class="[index <= calorieCount ? 'bg-green-500' : 'bg-gray-300']" class="min-h-20 shadow-inner">
                    </div>
                </div>
                <div v-if="calorieCount > 20"
                    class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col  gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                    <div v-for="index in 20" :key="index"
                        :class="[index + 20 <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']"
                        class="min-h-20 shadow-inner">
                    </div>
                </div>

                <p class="mt-6">What have you eaten today?</p>

                <div class="columns-2 sm:column-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">
                    <div @click="calorieCount += item.size" v-for="item, index in foodItems" :key="item"
                        :class="item.calH"
                        class="break-inside-avoid flex justify-center w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow">
                        <img class="object-cover h-full relative"
                            src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt="">
                        <div class="absolute top-50 left-50 text-gray-800 font-bold text-9xl drop-shadow-2xl"> {{
                            item.size
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GlobalLayout>

</template>
