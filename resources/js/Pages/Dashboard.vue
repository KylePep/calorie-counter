<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, } from '@inertiajs/vue3';
import { computed, ref } from "vue";
import Side from "@/Components/Displays/Side.vue";
import JournalEntry from "@/Components/Displays/JournalEntry.vue";
import CarrotDisplay from '../Components/Displays/CarrotDisplay.vue'
import CalorieDayLayout from "@/Layouts/CalorieDayLayout.vue";
import WeighInEntry from "@/Components/Displays/WeighInEntry.vue";
import MenuArray from "@/Components/Menu/MenuArray.vue";


const props = defineProps(['account', 'calorieDay', 'carrots', 'weighIn', 'foodItems', 'without_fdcId', 'with_fdcId']);

const renderHeroImage = computed(() => {
    if (props.account) {
        return null
    } else {
        return '/assets/dashboardNoAccount.jpeg'
    }
});

</script>

<template>

    <Head title="Dashboard">
        <meta type="description" content="Dashboard of CalorieCount" head-key="Dashboard">
    </Head>

    <GlobalLayout :heroImage="renderHeroImage" heroHeight="20">
        <template #header>
            <h2 v-if="props.account" class="font-semibold text-xl leading-tight">Calorie Counter</h2>
            <h2 v-else>
                <Link :href="route('calculator')"
                    class="text-accent-light hover:text-white hover:animate-none duration-300">
                Set a Goal <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i>
                </Link>
            </h2>
        </template>

        <CalorieDayLayout :account="account" :calorieDay="calorieDay" :with_fdc-id="with_fdcId"
            :without_fdc-id="without_fdcId" :foodItems="foodItems" :carrots="carrots" :weighIn="weighIn">
            Today: {{ new Date().toLocaleDateString() }}
        </CalorieDayLayout>

        <template #leftSide></template>

        <template #rightSide>
            <Side v-if="props.account" side="right" class="hidden sm:block">
                <WeighInEntry :weighIn="weighIn" />
                <JournalEntry :calorieDay="calorieDay" />
                <CarrotDisplay :carrots="carrots" />
                <MenuArray />
            </Side>
        </template>

    </GlobalLayout>

</template>
