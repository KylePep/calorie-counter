<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { onMounted } from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

onMounted(() => {

})

</script>

<template>



    <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Welcome">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Welcome</h2>
        </template>


        <h1 class="text-3xl text-center mb-12">Welcome to <strong>Calorie Counter</strong></h1>
        <div class="mb-12 py-4">
            <h2 class="text-2xl text-center mb-4">Here You'll be able to</h2>
            <ul class="space-y-2 max-w-sm lg:max-w-lg mx-auto list-disc">
                <li>Create an account and a goal</li>
                <li>Log the calories you've consumed over the course of a day</li>
                <li>Search for food items using the Usda database</li>
                <li>Save Usda food items or create them from scratch</li>
                <li>Visually compare calories to your goal using a representative progress bar</li>
                <li>Review all logged days</li>
            </ul>
        </div>

        <h3 class="pb-12 text-xl text-center">
            Register now to get started!
        </h3>

        <div class="flex justify-around max-w-lg mx-auto">
            <Link :href="route('login')">
            <PrimaryButton>
                Log in
            </PrimaryButton>
            </Link>
            <p class="text-gray-600">or</p>
            <Link :href="route('register')">
            <PrimaryButton>
                Register
            </PrimaryButton>
            </Link>
        </div>

    </GlobalLayout>


</template>