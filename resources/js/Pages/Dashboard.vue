<script setup>
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, } from '@inertiajs/vue3';
import { computed, ref } from "vue";
import Side from "@/Components/Displays/Side.vue";
import JournalEntry from "@/Components/Displays/JournalEntry.vue";
import CarrotDisplay from '../Components/Displays/CarrotDisplay.vue'
import CalorieDayLayout from "@/Layouts/CalorieDayLayout.vue";
import CalorieKey from '@/Components/Displays/CalorieKey.vue'


const props = defineProps(['account', 'calorieDay', 'with_fdcId', 'without_fdcId', 'carrots']);

const renderHeroImage = computed(() => {
    if (props.account) {
        return null
    } else {
        return '/assets/dashboardNoAccount.jpeg'
    }
})

const calorieDay = ref(props.calorieDay)
const goal = computed(() => calorieDay.value?.goal);
const bmr = computed(() => calorieDay.value?.bmr);

const calorieCount = computed(() => calorieDay.value?.count ?? 0);

</script>

<template>

    <Head title="Dashboard">
        <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
    </Head>

    <GlobalLayout :heroImage="renderHeroImage" heroHeight="20">
        <template #header>
            <h2 v-if="props.account" class="font-semibold text-xl leading-tight">Dashboard</h2>
            <h2 v-else>
                <Link :href="route('calculator')"
                    class="text-accent-yellow hover:text-white hover:animate-none duration-300">
                Set a Goal <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i>
                </Link>
            </h2>
        </template>

        <CalorieDayLayout :account="account" :calorie-day="calorieDay" :with_fdc-id="with_fdcId"
            :without_fdc-id="without_fdcId" :carrots="carrots">

            <p class="col-span-3 sm:col-span-1">
                Today: {{ new Date().toLocaleDateString() }}
            </p>
            <p>
                calories:
                {{ calorieCount }}
            </p>
            <p>
                Goal:
                {{ goal }}
            </p>
            <p>
                BMR:
                {{ bmr }}
            </p>

        </CalorieDayLayout>

        <template #leftSide>
            <Side side="left" v-if="props.account">
                <CalorieKey />
            </Side>
        </template>

        <template #rightSide>
            <Side v-if="props.account" side="right">
                <JournalEntry :calorieDay="calorieDay" />
                <CarrotDisplay :carrots="carrots" />
            </Side>
            <Side v-if="props.account" side="right" class="hidden sm:block">
                <CreateFood />
            </Side>
        </template>

    </GlobalLayout>

</template>
