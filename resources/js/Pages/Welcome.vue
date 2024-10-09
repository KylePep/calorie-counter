<script setup>
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

        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Welcome</h2>
        </template> -->

        <section class="space-y-3 text-center ">

            <h1 class="text-3xl">Welcome to <strong>Calorie Counter</strong></h1>
            <h2>Be sure to log in to keep log in so you can calculate your calorie goals and begin keeping track!</h2>

            <div v-if="canLogin && !$page.props.auth.user" class="min-h-96 grid grid-cols-1 place-items-center">
                <Link :href="route('login')"
                    class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">
                Returning?
                </Link>
                <p class="font-bold text-black/25 text-3xl">Or</p>
                <Link :href="route('register')"
                    class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">New here?
                </Link>
            </div>

            <div v-else class="min-h-96 grid grid-cols-1 place-items-center">
                <Link :href="route('calculator')"
                    class="text-4xl font-bold bg-gray-600 hover:bg-gray-500 py-3 px-6 rounded text-white">
                Calculate BMR
                </Link>
            </div>

        </section>

    </GlobalLayout>


</template>