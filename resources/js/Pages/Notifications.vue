<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onBeforeMount, onMounted} from "vue";
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
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="n in props.notifications">
                    <div class="pa-12 ma-6 sm:p-8 bg-white shadow sm:rounded-lg">
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    p {
        font-size: 20px;
    }
</style>
