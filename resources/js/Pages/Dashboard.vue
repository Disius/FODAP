<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onBeforeMount, onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
const props = defineProps({
    auth: Object
});


onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    })
});


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
        </template>

        <div class="py-12">
            <template v-if="props.auth.user.docente_id === null">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pa-12">
                            <v-banner
                                lines="three"
                                icon="mdi-account-box"
                                color="warning"
                                class="my-4"
                            >
                                <v-banner-text class="text-h5 text-center">

                                    ¡Si es la primera vez que ingresas al sistema debes actualizar tus datos!


                                </v-banner-text>

                                <template v-slot:actions>
                                    <NavLink :href="route('profile.edit')" as="button">
                                        <v-btn color="warning" elevation="2">Ir</v-btn>
                                    </NavLink>
                                </template>
                            </v-banner>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </AuthenticatedLayout>
</template>
