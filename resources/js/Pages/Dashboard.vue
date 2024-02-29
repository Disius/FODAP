<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {FODAPStore} from "@/store/server.js";
import Dropdown from "@/Components/Dropdown.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Instalar from "@/Pages/Installer/Instalar.vue";


const store = FODAPStore()
const props = defineProps({
    auth: Object,
    notifications: Array,
    can_install: Boolean,
    sesion: Object,
    token: String
});

console.log(props.token)

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
    });

    store.admin_get()
});
</script>

<template>
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

                                        ¡Debes actualizar tus datos!


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
                <template v-if="props.notifications.length !== 0">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="pa-12 ma-6 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="flex justify-center">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notificaciones mas recientes</h2>
                            </div>
                            <template v-if="props.notifications.length < 5">
                                <div  class="mt-5" v-for="n in props.notifications">
                                    <v-alert
                                        border="end"
                                        border-color="success"
                                        elevation="2"
                                        class=""
                                    >
                                        <p>{{n.data.email}} {{n.data.messegue}}</p>
                                        <div class="flex justify-center">
                                            <div class="">
                                                <NavLink :href="n.data.route + '/' + n.data.id" as="button">
                                                    <v-btn color="blue-darken-1" prepend-icon="mdi-eye" width="400">Ver</v-btn>
                                                </NavLink>
                                            </div>
                                            <!--                                <div class="flex justify-center">-->
                                            <!--                                    <NavLink :href="route('markNotification')" :data="{ id: n.id }" method="post" as="button">-->
                                            <!--                                        <v-btn color="success" prepend-icon="mdi-check-circle-outline" width="400">Marcar como leida</v-btn>-->
                                            <!--                                    </NavLink>-->
                                            <!--                                </div>-->
                                        </div>
                                    </v-alert>
                                </div>
                            </template>
                            <template v-else>
                                <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                                    <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                                        <v-alert
                                            color="blue-darken-1"
                                            icon="mdi-alert-circle"
                                            prominent
                                        >
                                            Actualmente tiene mas de 5 notificaciones, no olvide limpiar la seccion de notificaciones.
                                        </v-alert>
                                    </div>
                                </div>
                            </template>
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
            </div>
        </AuthenticatedLayout>
</template>
