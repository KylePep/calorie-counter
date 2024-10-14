<script setup>
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import ItemsDisplay from "@/Components/ItemsDisplay.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Pop from "@/utils/Pop.js";
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

async function removeAndSubtractFoodItem(foodItem) {
    const data = {
        remove: true,
        goal: calorieDay.value.goal,
        count: foodItem.count,
        food_items: [{ description: foodItem.description, count: foodItem.count }]
    };
    try {
        const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
        calorieDay.value = res.data
        Pop.success(`removed ${food_items.description}`)
    } catch (error) {

    }
}

async function updateCalorieDayUSDA(foodItem) {
    const totalCalories = foodItem.calories

    try {
        const data = {
            goal: calorieDay.value.goal,
            count: totalCalories,
            food_items: [{ description: foodItem.description, count: totalCalories }]
        }
        const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
        calorieDay.value = res.data
        Pop.success(`+ ${data.count} Calories`)
    } catch (error) {

    }

}
async function updateCalorieDayFoodItem(foodItem) {
    try {
        const data = {
            goal: calorieDay.value.goal,
            count: foodItem.calories,
            food_items: [{ description: foodItem.description, count: foodItem.calories }]
        };
        const res = await axios.put(route('calorieDay.update', calorieDay.value.id), data)
        calorieDay.value = res.data
        Pop.success(`+ ${data.count} Calories`)
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

            <section class="space-y-4">
                <ul>
                    <h1 class="font-bold">
                        Known Issues:
                    </h1>
                    <li>Nutrients are not represented on/within form</li>
                    <li>Buttons on FoodCards do not function</li>
                    <li>-Edit</li>
                    <li>-Delete</li>
                    <li>-Add</li>
                    <li>UsdaFoodCard missing function</li>
                    <li>-Edit</li>
                    <li>--This can be the purpose of the edit button, Need click usda item, run usda get -> item id
                    </li>
                </ul>
                <ul>
                    <h1 class="font-bold">
                        Wishlist
                    </h1>
                    <li>Meals</li>
                    <li>-New data object where you can assemble several food Items, from usda and your own.</li>
                    <li>History configurable, sortable by month etc</li>
                    <li></li>
                </ul>
            </section>

            <section>
                <div v-if="!props.account" class="pb-3">
                    Please complete setting up your account to begin tracking your progress or begin by
                    <Link class="font-bold" :href="route('calculator')">
                    calculating your goal!
                    </Link>
                </div>

                <p class="text-xl font-bold">
                    Here's how it's going: {{ calorieCount }}, Your goal is {{ calorieGoal }} calories
                </p>
            </section>


            <section class=" z-10 bg-white p-1 text-center border-4 rounded-lg border-black/25"
                :class="calorieCount < calorieGoal ? 'sticky top-16' : ''">

                <div v-for="row in calorieCountRows" :key="row" class="  grid grid-rows-1 grid-flow-col gap-1 mb-1">
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

            <section v-if="props.account && calorieDay.food_items.length">
                <ConsumedList :dayItems="calorieDay.food_items" @remove-food-item="removeAndSubtractFoodItem" />
            </section>

            <section v-if="props.account">
                <CreateFood />
            </section>

            <section v-if="props.account">
                <ItemsDisplay size="sm" :list="without_fdcId" @item-Activated="updateCalorieDayFoodItem">
                    <h1 class="text-xl font-bold">Your Foods</h1>
                </ItemsDisplay>
            </section>

            <section v-if="props.account">
                <ItemsDisplay size="sm" :list="with_fdcId" @item-Activated="updateCalorieDayFoodItem">
                    <h1 class="text-xl font-bold">Favorite Foods</h1>
                </ItemsDisplay>
            </section>

            <section>
                <FoodList @increase-by="updateCalorieDayUSDA" />
            </section>

        </div>
    </GlobalLayout>

</template>
