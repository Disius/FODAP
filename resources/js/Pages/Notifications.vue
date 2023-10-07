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
                    <v-btn color="success" prepend-icon="mdi-check-circle-outline" width="400">Marcar como leida</v-btn>
                </NavLink>
            </template>
        </template>


        <template v-if="props.notifications.length !== 0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pa-12 ma-6 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div  class="mt-5" v-for="n in props.notifications">
                        <v-alert
                            border="end"
                            border-color="success"
                            elevation="2"
                            class=""
                        >
                            <p>{{n.data.email}} {{n.data.messegue}}</p>
                            <div class="grid grid-cols-2">
                                <div class="flex justify-end">
                                    <NavLink :href="n.data.route + '/' + n.data.id" as="button">
                                        <v-btn color="blue-darken-1" prepend-icon="mdi-eye" width="400">Ver</v-btn>
                                    </NavLink>
                                </div>
                                <div class="flex justify-center">
                                    <NavLink :href="route('markNotification')" :data="{ id: n.id }" method="post" as="button">
                                        <v-btn color="success" prepend-icon="mdi-check-circle-outline" width="400">Marcar como leida</v-btn>
                                    </NavLink>
                                </div>
                            </div>
                        </v-alert>
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
