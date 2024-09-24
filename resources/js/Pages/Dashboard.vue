<script setup>
import TextInput from "@/Components/TextInput.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from "vue";


const foodItems = [
    { calH: 'h-[10rem]', size: 100 },
    { calH: 'h-[20rem]', size: 200 },
    { calH: 'h-[40rem]', size: 400 },
    { calH: 'h-[10rem]', size: 100 },
    { calH: 'h-[50rem]', size: 500 },
    { calH: 'h-[20rem]', size: 200 },
    { calH: 'h-[10rem]', size: 100 },
    { calH: 'h-[10rem]', size: 100 },
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
            <div class="space-y-4">
                <p>
                    {{ $page.props.foodData.description }}
                </p>
                <p>
                    {{ $page.props.foodData.brandOwner }}

                </p>
                <p>
                    Serving Size:
                    {{ $page.props.foodData.servingSize }}

                    {{ $page.props.foodData.servingSizeUnit }}
                </p>
                <p>
                    Food Category:
                    {{ $page.props.foodData.brandedFoodCategory }}

                </p>

                <ul>
                    <li>Nutrients</li>
                    <li class="my-2" v-for="(value, name, index) in $page.props.foodData.labelNutrients">
                        {{ name }}: {{ value.value }}
                    </li>
                </ul>
                <p>
                    {{ $page.props.foodData.ingredients }}
                </p>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p>
                    Here's how it's going: {{ calorieCount }}, Your goal is 2000 calories
                </p>
                <div
                    class="sticky top-16 z-10 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                    <div v-for="index in 40" :key="index"
                        :class="[index * 50 <= calorieCount ? 'bg-green-500' : 'bg-gray-300']" class="min-h-20">
                    </div>
                </div>
                <div v-if="calorieCount > 2000"
                    class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                    <div v-for="index in 40" :key="index"
                        :class="[index * 50 + 2000 <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']" class="min-h-20">
                    </div>
                </div>

                <p class="mt-6">Favorites</p>
                <div class="columns-2 sm:column-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">
                    <div @click="calorieCount += item.size" v-for="item, index in foodItems" :key="item"
                        :class="item.calH"
                        class="break-inside-avoid relative flex justify-center w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow">
                        <img class="object-cover object-center h-full "
                            src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt="">
                        <div class="absolute inset-y-1/4 text-gray-800 font-bold text-7xl drop-shadow-2xl"> {{
                            item.size
                        }}
                        </div>
                    </div>
                </div>

                <p class="mt-6">Search?</p>
                <form action="" method="get">
                    <label for="" class="block font-bold">USDA</label>
                    <div class="flex mb-3">
                        <TextInput /> <i class="mdi mdi-magnify text-black text-4xl"></i>
                    </div>
                </form>
                <div class="columns-2 sm:column-3 gap-2 p-2 text-center border-4 rounded-lg border-black/25 ">
                    <div @click="calorieCount += item.size" v-for="item, index in foodItems" :key="item"
                        :class="item.calH"
                        class="break-inside-avoid relative flex justify-center w-full hover:bg-gray-200 bg-gray-300 mb-6 p-3 shadow">
                        <img class="object-cover object-center h-full "
                            src="https://i.pinimg.com/564x/83/00/f9/8300f96bc390b6f44540a92b77b93365.jpg" alt="">
                        <div class="absolute inset-y-1/4 text-gray-800 font-bold text-7xl drop-shadow-2xl"> {{
                            item.size
                        }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GlobalLayout>

</template>
