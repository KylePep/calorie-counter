<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import Side from "@/Components/Displays/Side.vue";
import MenuButton from "@/Components/Menu/MenuButton.vue";

const props = defineProps(['mustVerifyEmail', 'status']);

</script>

<template>

    <GlobalLayout head="Profile">

        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Profile</h2>
        </template>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                        class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>

        <template #rightSide>
            <div>
                <Link :href="route('account.index')" class="w-full">
                <MenuButton>
                    Return
                </MenuButton>
                </Link>
            </div>
        </template>

    </GlobalLayout>

</template>
