<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50">
        <div class="relative min-h-screen flex justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <header class="grid grid-cols-2 gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
                        Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
                            Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
                            Register
                            </Link>
                        </template>

                    </nav>
                </header>

                <main class="mt-6 text-center space-y-6">

                    <section class="space-y-3">
                        <h1 class="text-6xl">Goal:
                        </h1>
                        <p>Create a web app that helps you keep track of your calories
                        </p>
                        <p>Currently, creating a user is entirely handled by the breeze starter kit</p>
                        <h2 class="text-5xl">
                            In this app you will:
                        </h2>
                        <p>
                        <ul>
                            <li>Create an account</li>
                            <li>Determine current calorie requirements</li>
                            <li>Determine desired weight calorie requirements</li>
                            <li>Return daily to record the days progress or previous days total calories</li>
                        </ul>
                        </p>
                    </section>

                    <section class="space-y-3">
                        <h1 class="text-4xl">The Mifflin-St Jeor Equation will be used</h1>
                        <h2 class="text-3xl">
                            Formula
                        </h2>

                        <p>
                            Females: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) – 161

                        </p>
                        <p>
                            Males: (10*weight [kg]) + (6.25*height [cm]) – (5*age [years]) + 5
                        </p>
                        <div class="">
                            <h2 class="text-2xl">
                                Multiply by scale factor for activity level:

                            </h2>
                            <ul class="">
                                <li>
                                    Sedentary *1.2

                                </li>
                                <li>
                                    Lightly active *1.375


                                </li>
                                <li>
                                    Moderately active *1.55

                                </li>
                                <li>
                                    Active *1.725

                                </li>
                                <li>
                                    Very active *1.9

                                </li>
                            </ul>

                        </div>
                    </section>
                </main>

                <footer class="">
                </footer>

            </div>
        </div>
    </div>
</template>