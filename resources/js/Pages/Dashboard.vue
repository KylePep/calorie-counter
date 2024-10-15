<script setup>
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import ItemsDisplay from "@/Components/ItemsDisplay.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Pop from "@/utils/Pop.js";
import { Head, } from '@inertiajs/vue3';
import axios from "axios";
import { computed, ref } from "vue";
import CalorieDisplay from '../Components/FoodComponents/CalorieDisplay.vue'

const props = defineProps(['account', 'calorieDay', 'with_fdcId', 'without_fdcId']);

const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const calorieDay = ref(props.calorieDay)

const goal = computed(() => calorieDay.value?.goal ?? 2000);
const calorieCount = computed(() => calorieDay.value?.count ?? 0);

const calorieGoal = ref(goal)

const showEditForm = ref(false);
const showUsdaForm = ref(false);
const ActiveFoodItem = ref({})

function setActive(foodItem, type) {
    showEditForm.value = false;
    showUsdaForm.value = false;
    if (type == 'usda') {
        showUsdaForm.value = true;
    } else showEditForm.value = true;
    ActiveFoodItem.value = foodItem;
}
const closeModal = () => {
    showEditForm.value = false;
    showUsdaForm.value = false;
    ActiveFoodItem.value = {};
}

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

function handleExtraButton(item, action, type) {
    console.log(item, action, type)
    if (action == 'edit') {
        setActive(item, type)
    } else if (action == 'add') {
        updateCalorieDayFoodItem(item)
    } else {
        return
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
                <ul class="list-disc">
                    <h1 class="font-bold">
                        To Do:
                    </h1>
                    <li>Ability to edit Calorie Day</li>
                    <li>-- Edit button->calorieDay.index</li>
                    <li>Edit Usda form, altered to fit needs</li>
                    <li>Edit Usda form, loading screen</li>
                    <li class="line-through text-gray-400">Scrolling text needs adjustment on consumed list</li>
                    <li class="line-through text-gray-400">Consumed List cursor-pointer</li>
                    <li class="line-through text-gray-400">Profile should have recorded account details editable</li>
                    <li class="line-through text-gray-400">FoodList no search, remove hover</li>
                </ul>
                <ul class="list-disc">
                    <h1 class="font-bold">
                        To Be Done:
                    </h1>
                    <li>Standardization of components, maybe move some styling into tailwind config</li>
                    <li>Introduce themes and colors</li>
                    <li>Look for opportunities for transitions. Like loading etc</li>
                </ul>
            </section>

            <section>
                <div v-if="!props.account" class="pb-3">
                    Please complete setting up your account to begin tracking your progress or begin by
                    <Link class="font-bold" :href="route('calculator')">
                    calculating your goal!
                    </Link>
                </div>

                <p v-else class="text-xl font-bold">
                    Here's how it's going: {{ calorieCount }}, Your goal is {{ calorieGoal }} calories {{ new
                        Date().toLocaleDateString() }}
                </p>
            </section>

            <CalorieDisplay v-if="props.account" :calorieGoal="calorieGoal" :calorieCount="calorieCount" />

            <section v-if="props.account && calorieDay.food_items.length">
                <ConsumedList :dayItems="calorieDay.food_items" @remove-food-item="removeAndSubtractFoodItem" />
            </section>

            <section v-if="props.account">
                <CreateFood />
            </section>

            <section v-if="props.account">
                <ItemsDisplay size="sm" :list="without_fdcId" @item-Activated="updateCalorieDayFoodItem"
                    @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
                    <h1 class="text-xl font-bold">Your Foods</h1>
                </ItemsDisplay>
            </section>

            <section v-if="props.account">
                <ItemsDisplay size="sm" :list="with_fdcId" @item-Activated="updateCalorieDayFoodItem"
                    @extra-button="(item, action) => handleExtraButton(item, action, 'foodItem')">
                    <h1 class="text-xl font-bold">Favorite Foods</h1>
                </ItemsDisplay>
            </section>

            <section>
                <FoodList @increase-by="updateCalorieDayFoodItem"
                    @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
            </section>

            <FoodEditModal :showModal="showEditForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
            <UsdaFoodEditModal :showModal="showUsdaForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

        </div>
    </GlobalLayout>

</template>
