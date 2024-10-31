<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import UsdaFeature from "./partial/UsdaFeature.vue";
import AccountFeature from "./partial/AccountFeature.vue";
import ProgressFeature from "./partial/ProgressFeature.vue";

const props = defineProps(['canLogin', 'canRegister', 'account']);
</script>

<template>
    <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Welcome" heroImage="/assets/CalorieCounter.jpeg"
        heroHeight="10">

        <template #header>
            Calories? Counted <i class="mdi mdi-heart-box"></i>
        </template>

        <div class="min-h-screen flex flex-col justify-between space-y-24">

            <section class="text-center text-neutral sm:min-h-96">
                <UsdaFeature />
            </section>

            <section class="text-center text-neutral min-h-96">
                <AccountFeature />
            </section>

            <section class="text-center text-neutral min-h-96">
                <ProgressFeature />
            </section>

        </div>

    </GlobalLayout>
</template>