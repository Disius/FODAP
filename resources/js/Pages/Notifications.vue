<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {computed, onBeforeMount, onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
const props = defineProps({
    auth: Object,
    notifications: Array,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notificaciones</h2>
            <template v-if="props.notifications.length !== 0">
                <NavLink :href="route('markNotification')" method="post" as="button">
                    <v-btn color="success" prepend-icon="mdi-check-circle-outline" width="400">Marcar como leidas</v-btn>
                </NavLink>
            </template>
        </template>


        <template v-if="props.notifications.length !== 0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pa-12 ma-6 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div v-for="notification in props.notifications" :key="notification.id">
                        <v-card width="400">
                            <template v-slot:title>
                                {{notification.data.email}}
                            </template>

                            <template v-slot:subtitle>

                            </template>

                            <template v-slot:text>
                                <p class="text-start">{{notification.data.messegue}}</p>
                            </template>
                            <template v-slot:actions>
                                <div class="d-flex justify-space-between px-4 pt-4">
                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                        <NavLink :href="notification.data.route + '/' + notification.data.id" type="button" as="button">
                                            <v-chip variant="flat" color="info" prepend-icon="mdi-eye-arrow-right-outline">
                                                Ver notificacion
                                            </v-chip>
                                        </NavLink>
                                        <NavLink :href="route('markNotification', notification.id)" type="button" as="button" method="post" :data="{id: notification.data.id}">
                                            <v-chip variant="flat" color="success" prepend-icon="mdi-check-circle">
                                                Pendiente a revisar
                                            </v-chip>
                                        </NavLink>
                                    </div>
                                </div>
                            </template>
                        </v-card>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pa-12 ma-6 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-alert
                            type="info"
                            icon="$info"
                            elevation="2"
                            class=""
                        >
                            Sin notificaciones recientes
                        </v-alert>
                    </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style>
    p {
        font-size: 20px;
    }
</style>
