<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaDetecciones from "@/Pages/Views/desarrollo/tablas/TablaDetecciones.vue";
import TablaDeteccionesRegistrosCoordinacion
    from "@/Pages/Views/desarrollo/tablas/TablaDeteccionesRegistrosCoordinacion.vue";
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const props = defineProps({
   detecciones: Array,
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
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de todos los cursos que se llevaron acabo</h2>
        </template>

        <template v-if="props.detecciones.length !== 0">
            <div class="pt-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex justify-center">
                            <TablaDeteccionesRegistrosCoordinacion :detecciones="props.detecciones"></TablaDeteccionesRegistrosCoordinacion>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mt-16 pt-12 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                        color="blue-darken-1"
                        icon="mdi-alert-circle"
                        prominent
                    >
                        Actualmente no han finalizado cursos.
                    </v-alert>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>



</style>
