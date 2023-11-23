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
                    <v-data-iterator
                        :items="props.notifications"
                        item-value="nombreCurso"
                    >
                        <template v-slot:default="{items}">
                            <v-container class="" fluid>
                                <v-row dense>
                                    <v-col v-for="item in items" :key="item.raw.data.email"
                                           cols="auto"
                                           md="4"
                                    >
                                        <v-card class="pb-3" border flat >
                                            <v-list-item class="mb-2" :subtitle="item.raw.data.messegue">
                                                <template v-slot:title>
                                                    <strong class="text-h6 mb-2">
                                                        {{item.raw.data.email}}
                                                    </strong>
                                                </template>
                                            </v-list-item>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">

                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4 pt-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <NavLink :href="item.raw.data.route + '/' + item.raw.data.id" as="button">
                                                        <v-btn color="blue-darken-1"
                                                               border
                                                               flat
                                                               size="small"
                                                               class="text-none"
                                                               text="Ver"
                                                               prepend-icon="mdi-eye-arrow-right-outline">Ver</v-btn>
                                                    </NavLink>
                                                    <NavLink :href="route('markNotification')" :data="{ id: item.raw.data.id }" method="post" as="button">
                                                        <v-btn color="success"
                                                               prepend-icon="mdi-check-circle-outline"
                                                               border
                                                               flat
                                                               size="small"
                                                               class="text-none"
                                                               text="Ver"
                                                               type="submit"
                                                               >Marcar como leida</v-btn>
                                                    </NavLink>
                                                </div>

                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </template>
                    </v-data-iterator>
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
