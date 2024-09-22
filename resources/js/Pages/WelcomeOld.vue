<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    name: {
        type: String
    }
    // laravelVersion: {
    //     type: String,
    //     required: true,
    // },
    // phpVersion: {
    //     type: String,
    //     required: true,
    // },
});

// function handleImageError() {
//     document.getElementById('screenshot-container')?.classList.add('!hidden');
//     document.getElementById('docs-card')?.classList.add('!row-span-1');
//     document.getElementById('docs-card-content')?.classList.add('!flex-row');
//     document.getElementById('background')?.classList.add('!hidden');
// }
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

                <main class="mt-6 h-full text-center">
                    Hello, {{ name }}
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                </footer>

            </div>
        </div>
    </div>
</template>
