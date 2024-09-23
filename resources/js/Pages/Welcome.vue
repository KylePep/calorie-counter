<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";

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



    <GlobalLayout :canLogin="canLogin" :canRegister="canRegister" head="Welcome">

        <section class="space-y-3 text-center">

            <h1 class="text-3xl">Welcome to <strong>Calorie Counter</strong></h1>
            <h2>Be sure to log in to keep log in so you can calculate your calorie goals and begin keeping track!</h2>
            <div class="min-h-96 grid grid-cols-1 place-items-center">
                <Link v-if="canLogin && !$page.props.auth.user" :href="route('login')"
                    class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">
                Log In
                </Link>
                <Link :href="route('register')"
                    class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">Register
                </Link>
            </div>

        </section>

    </GlobalLayout>


</template>


<!-- <Head title="Welcome" />
<div class="bg-gray-50 text-black/50">
    <div class="relative flex justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <header class="grid grid-cols-2 gap-2 py-10 ">
                <div class="text-2xl font-bold text-black/75">
                    <Link href="/"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] uppercase">
                    Calorie Counter
                    </Link>
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
                        <Link v-if="canRegister" :href="route('calculator')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
                        Calculate
                        </Link>
                    </template>

                </nav>
            </header>


        </div>
    </div>
</div>

<main class="mt-6 space-y-6 max-w-3xl mx-auto min-h-full text-center text-black/75">

    <section class="space-y-3">
        <h1 class="text-3xl">Welcome to <strong>Calorie Counter</strong></h1>
        <h2>Be sure to log in to keep log in so you can calculate your calorie goals and begin keeping track!</h2>
        <div class="min-h-96 grid grid-cols-1 place-items-center">
            <Link v-if="canLogin && !$page.props.auth.user" :href="route('login')"
                class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">
            Log In
            </Link>
           <Link class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">Register
            </Link>
</div>
</section>

 <section class="space-y-3">
        <h1 class="text-6xl">Goal:
        </h1>
        <p>Create a web app that helps you keep track of your calories.
        </p>
        <p>Create a good looking and intuitive web app.</p>
        <p>Currently, creating a user is entirely handled by the breeze starter kit.</p>
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
        <h1 class="text-4xl">Reference:
        </h1>
        <p>Calculator.net- The app has a lot of what I am looking for but is very unappealing.
        </p>
    </section> 


</main>

<footer class="">
</footer>  -->