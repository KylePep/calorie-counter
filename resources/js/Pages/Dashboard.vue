<script setup>
import CreateFood from "@/Components/CreateFood.vue";
import FavoriteFoodList from "@/Components/FavoriteFoodList.vue";
import FoodList from "@/Components/FoodList.vue";
import YourFoodsList from "@/Components/YourFoodsList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, } from '@inertiajs/vue3';
import axios from "axios";
import { computed, ref } from "vue";

const props = defineProps(['account', 'calorieDay', 'with_fdcId', 'without_fdcId'])

const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const calorieDay = ref(props.calorieDay)

const goal = computed(() => calorieDay.value?.goal ?? 2000);
const calorieCount = computed(() => calorieDay.value?.count ?? 0);

const calorieGoal = ref(goal)
const cellCount = ref(calorieGoal.value / 100)
const calorieCountRows = ref(Math.ceil(calorieGoal.value / 1000))

const dayItems = computed(() => {
    if (calorieDay.value.length == 0) {
        return []
    } else {
        return calorieDay.value.food_items
            .split('"')
            .filter((item, index) => index % 2 !== 0 && item.trim());
    }
})


async function updateCalorieDayUSDA(foodItem) {
    const data = {
        goal: calorieDay.value.goal,
        count: Math.round(foodItem.foodNutrients[3].value * (foodItem.servingSize * .01)),
        food_items: [foodItem.description]
    }
    try {
        const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
        calorieDay.value = res.data
    } catch (error) {

    }

}
async function updateCalorieDayFoodItem(foodItem) {
    const data = {
        goal: calorieDay.value.goal,
        count: foodItem.calories,
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

        <div class="space-y-4 max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">

            <section>
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
            </section>


            <section class=" z-10 bg-white p-1 text-center border-4 rounded-lg border-black/25"
                :class="calorieCount < calorieGoal ? 'sticky top-16' : ''">

                <div v-for="row in calorieCountRows" :key="row" class="  grid grid-rows-1 grid-flow-col gap-1 mb-1">
                    <!-- {{ row * 1000 }} -->
                    <div v-for="index in 10" :key="index"
                        :class="[((row - 1) * 10 + index) * 100 <= calorieCount && index + ((row - 1) * 10) <= cellCount ? 'bg-green-500 text-transparent' : 'bg-gray-300 text-black/50', index + ((row - 1) * 10) <= cellCount ? '' : 'bg-black/25 text-transparent']"
                        class="min-h-10 text-sm flex flex-col justify-center duration-300">
                        100
                    </div>
                </div>
            </section>

            <section v-if="calorieCount > calorieGoal"
                class="sticky top-16 z-20 grid grid-rows-2 grid-flow-col gap-1 bg-white p-1 text-center border-4 rounded-lg border-black/25">
                <div v-for="index in 40" :key="index"
                    :class="[index * 50 + calorieGoal <= calorieCount ? 'bg-yellow-500' : 'bg-gray-300']"
                    class="min-h-10 duration-300">
                </div>
            </section>

            <section v-if="props.account">
                <h1 class="text-xl font-bold pb-3">Eaten</h1>
                <div
                    class=" p-2 pb-0 grid grid-rows-3 grid-flow-col gird- text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap gap-1">
                    <div v-for="item in dayItems" :key="item" class="inline-block bg-gray-300 rounded-lg px-2">
                        <p class="max-h-10 overflow-hidden font-bold">
                            {{ item }}
                        </p>

                    </div>
                </div>
            </section>

            <section v-if="props.account">
                <CreateFood />
            </section>

            <section v-if="props.account">
                <YourFoodsList :without_fdcId="without_fdcId" @increase-by="updateCalorieDayFoodItem" />
            </section>

            <section v-if="props.account">
                <FavoriteFoodList :with_fdcId="with_fdcId" @increase-by="updateCalorieDayFoodItem" />
            </section>

            <section>
                <FoodList @increase-by="updateCalorieDayUSDA" />
            </section>

        </div>
    </GlobalLayout>

</template>
