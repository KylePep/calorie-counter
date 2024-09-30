<script setup>
import FoodList from "@/Components/FoodList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, } from '@inertiajs/vue3';
import axios from "axios";
import { computed, ref } from "vue";

const props = defineProps(['account', 'calorieDay'])
const calorieDay = ref(props.calorieDay)

const goal = computed(() => calorieDay.value?.goal ?? 2000);
const calorieCount = computed(() => calorieDay.value?.count ?? 0);

const calorieGoal = ref(goal)
const cellCount = ref(calorieGoal.value / 100)
const calorieCountRows = ref(Math.ceil(calorieGoal.value / 1000))


async function updateCalorieDay(foodItem) {
    const data = {
        goal: calorieDay.value.goal,
        count: Math.round(foodItem.foodNutrients[3].value * (foodItem.servingSize * .01)),
        food_items: [foodItem.description]
    };

    try {
        const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
        calorieDay.value = res.data
    } catch (error) {

    }

}

</script>

<template>

    <Head title="Dashboard">
        <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
    </Head>

    <GlobalLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <p class="text-3xl text-green-500 mx-4">
        <ul class="list-disc">
            <li>FoodList needs the ability to convert USDA foodData items into user FoodItems</li>
        </ul>
        </p>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <div v-if="!props.account" class="pb-3">
                Please complete setting up your account to begin tracking your progress or begin by
                <Link class="font-bold" :href="route('calculator')">
                calculating your goal!
                </Link>
            </div>

            <p>
                Here's how it's going: {{ calorieCount }}, Your goal is {{ calorieGoal }} calories
            <p>
                -- rows {{
                    calorieCountRows }} -- cells {{
                    cellCount }}
            </p>
            </p>
            <div class=" z-10 bg-white p-1 text-center border-4 rounded-lg border-black/25"
                :class="calorieCount < calorieGoal ? 'sticky top-16' : ''">

                <div v-for="row in calorieCountRows" :key="row" class="  grid grid-rows-1 grid-flow-col gap-1 mb-1">
                    <!-- {{ row * 1000 }} -->
                    <div v-for="index in 10" :key="index"
                        :class="[((row - 1) * 10 + index) * 100 <= calorieCount && index + ((row - 1) * 10) <= cellCount ? 'bg-green-500 text-transparent' : 'bg-gray-300 text-black/50', index + ((row - 1) * 10) <= cellCount ? '' : 'bg-black/25 text-transparent']"
                        class="min-h-10 text-sm flex flex-col justify-center">
                        100
                    </div>
                </div>
            </div>

            <div v-if="calorieCount > calorieGoal"
                class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                <div v-for="index in 40" :key="index"
                    :class="[index * 50 + calorieGoal <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']"
                    class="min-h-10">
                </div>
            </div>

            <!-- <p class="mt-6">Favorites</p>
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
                </div> -->

            <FoodList :calorieCount="calorieCount" @increase-by="updateCalorieDay" />
        </div>
    </GlobalLayout>

</template>
