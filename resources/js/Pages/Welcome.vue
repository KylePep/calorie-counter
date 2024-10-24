<script setup>
import ConsumedList from "@/Components/FoodComponents/ConsumedList.vue";
import FoodCard from "@/Components/FoodComponents/FoodCard.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { onMounted } from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    account: {
        type: Object
    }
});

const mockItem = { "id": 1, "fdcId": null, "description": "Mega PB&J", "calories": 500, }
const mockItem2 = { "id": 2, "fdcId": null, "description": "Fried Egg", "calories": 100, }

const mockList = [{ "description": "Mega PB&J", "count": 500 }, { "description": "Fried Egg", "count": 100 }, { "description": "Fried Egg", "count": 100 }]
</script>

<template>



    <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Welcome"
        heroImage="/assets/CalorieCounter.jpeg">

        <template #header>
            Welcome
        </template>

        <div class="min-h-screen flex flex-col justify-between space-y-24">

            <section class="text-center text-neutral sm:min-h-96">
                <div class="relative border-b-4 border-neutral w-48 mx-auto mb-10">
                    <h2 class="absolute inset-x-0 -top-3 mx-8 text-center font-bold bg-main"> FEATURE #1
                    </h2>
                </div>

                <h3 class="capitalize  text-3xl font-bold">Powered By the usda database</h3>
                <h4 class="py-1 text-sm">CalorieCalculator uses the usda's database to get accurate diet information
                </h4>
                <div class="border-2 border-light shadow-xl rounded h-52 sm:h-96 mt-4" :style="{
                    backgroundImage: `url(/assets/usdaDesktop.png)`,
                    backgroundSize: '190%',
                    backgroundPosition: '37% 80%',
                    backgroundRepeat: 'no-repeat'
                }">
                </div>
            </section>

            <section class="text-center text-neutral min-h-96">
                <div class="relative border-b-4 border-neutral w-48 mx-auto mb-10">
                    <h2 class="absolute inset-x-0 -top-3 mx-8 text-center font-bold bg-main"> FEATURE #2
                    </h2>
                </div>

                <h3 class="capitalize text-3xl font-bold mb-4">Create an account</h3>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div>
                        <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
                            <i
                                class="absolute -left-4 top-0 mdi mdi-account-plus text-4xl text-accent-red group-hover:animate-pulse "></i>
                            <i class="absolute left-6 top-8 mdi mdi-format-list-bulleted-type text-5xl text-accent"></i>
                            <i class="absolute -bottom-4 -right-2 mdi mdi-login text-4xl text-accent-yellow"></i>
                        </div>
                        <h4 class="font-bold text-4xl py-1">
                            Sign up
                        </h4>
                        <p class="text-sm">Create a profile with the super simple registering process.</p>
                    </div>
                    <div>
                        <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
                            <i class="absolute -left-4 -bottom-4 mdi mdi-tape-measure text-5xl text-dark"></i>
                            <i
                                class="absolute left-4 top-2 mdi mdi-scale-balance text-6xl text-neutral group-hover:animate-bounce"></i>
                            <i
                                class="absolute -right-2 -bottom-4 mdi mdi-checkbox-marked-circle-plus-outline text-4xl text-light"></i>
                        </div>
                        <h4 class="font-bold text-4xl py-1">
                            Goals
                        </h4>
                        <p class="text-sm">
                            Take advantage of the BMR calculator using the Mifflin-St Jeor formula, or set your own
                            calorie goal.
                        </p>
                    </div>
                    <div>
                        <div class="group relative h-24 w-24 mx-auto text-shadow mb-6">
                            <i class="absolute -left-6 top-0 mdi mdi-scale text-4xl text-accent"></i>
                            <i class="absolute -right-5 top-0 mdi mdi-food-fork-drink text-4xl text-accent-red"></i>
                            <i class="absolute -bottom-8 left-8 mdi mdi-pencil-plus text-4xl text-accent-yellow"></i>
                            <i
                                class="absolute top-4 left-2 mdi mdi-robot-happy-outline text-7xl text-special group-hover:animate-spin"></i>
                        </div>
                        <h4 class="font-bold text-4xl py-1">
                            Tracking
                        </h4>
                        <p class="text-sm">
                            Search the USDA database for foods or create your own, then add them to your day to track
                            your
                            calories!
                        </p>
                    </div>
                </div>


            </section>

            <section class="text-center text-neutral min-h-96">
                <div class="relative border-b-4 border-neutral w-48 mx-auto mb-10">
                    <h2 class="absolute inset-x-0 -top-3 mx-8 text-center font-bold bg-main"> FEATURE #3
                    </h2>
                </div>

                <h3 class="capitalize  text-3xl font-bold">Unique and reactive feedback</h3>
                <div class=" grid grid-cols-2 gap-4 mt-4">
                    <div class="col-span-2">
                        <div class="flex flex-col h-full text-start ">
                            <div class="px-4 py-2 bg-neutral text-light rounded-t font-bold">
                                <p>While tracking your calories, each square will represent 100 calories.</p>
                                <p>Meaning you'll have a better representation of how much a single food item impacts
                                    your
                                    diet.</p>
                            </div>

                            <div class="mt-4">
                                <p class="text-center text-xl font-bold">Goal: 1800</p>
                                <div
                                    class="grid grid-cols-10 gap-1 px-1.5 py-0.5 rounded ring-1 ring-main ring-inset border-2  border border-light drop-shadow-xl bg-gradient-to-b from-main via-light to-light">
                                    <div v-for="index in 20"
                                        class="flex flex-col justify-center items-center text-neutral h-14 border border-neutral"
                                        :class="index < 8 ? 'bg-accent bg-gradient-to-b from-accent-dark via-accent via-50% to-accent-light text-transparent' : '', index > 18 ? 'bg-neutral text-transparent' : ''">
                                        100
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="px-4 py-2 bg-neutral text-light font-bold h-full">Higher calorie foods will
                            appear larger
                            compared to other foods in your
                            records
                            for the
                            day.
                        </p>

                    </div>

                    <div>
                        <p class="px-4 py-2 bg-neutral text-light font-bold h-full">Selecting foods from the
                            USDA's
                            database
                            or from your saved or
                            created
                            lists
                            will have a
                            preview
                            of how much room they'll take.
                        </p>
                    </div>

                    <div class="flex flex-col justify-end">
                        <ConsumedList :dayItems="mockList" />
                    </div>

                    <div>
                        <div class="flex w-full">
                            <FoodCard :foodItem="mockItem" />
                            <FoodCard :foodItem="mockItem2" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- <div v-if="!$page.props.auth.user" class="">
                <div class="text-center">
                    <h1 class="text-3xl mb-6">Welcome to <strong>Calorie Counter</strong></h1>
                    <ApplicationLogo class="text-7xl text-accent" />
                </div>
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

                <div class="flex justify-around max-w-sm mx-auto">
                    <Link :href="route('login')">
                    <PrimaryButton>
                        Log in
                    </PrimaryButton>
                    </Link>
                    <p class="text-text">or</p>
                    <Link :href="route('register')">
                    <PrimaryButton>
                        Register
                    </PrimaryButton>
                    </Link>
                </div>
            </div>

            <div v-else class="flex flex-col justify-between items-center">
                <h1 class="text-3xl text-center">Welcome back <br /> <strong>{{ $page.props.auth.user.name }}</strong>!
                </h1>
                <ApplicationLogo class="text-7xl text-accent" />
                <Link :href="route('dashboard')">
                <PrimaryButton>Get Counting!</PrimaryButton>
                </Link>
            </div> -->
        </div>


    </GlobalLayout>


</template>