<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted} from "vue";
import {Head} from "@inertiajs/vue3";
import TablaMisCursoDocente from "@/Pages/Views/cursos/tablas/TablaMisCursoDocente.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    docente: Object,
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
    });


});



</script>

<template>
    <Head title="Mis Cursos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Mis Cursos</h2>
        </template>

        <template v-if="props.docente !== null">
            <template v-if="props.docente.inscrito.length !== 0">
                <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                        <TablaMisCursoDocente :curso="props.docente" :user="props.auth"></TablaMisCursoDocente>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-alert
                            border="start"
                            color="info"
                            type="info"
                            title="Cursos"
                        >
                            <h2>Actualmente no estas inscrito a un curso o no estan disponbles !Pronto deberias verlos disponible!</h2>
                        </v-alert>
                    </div>
                </div>
            </template>
        </template>
        <template v-else>
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                    border="start"
                    color="info"
                    type="info"
                    title="Cursos"
                    >
                        <h2>Actualmente no estas inscrito a un curso o no estan disponbles !Pronto deberias verlos disponible!</h2>
                    </v-alert>
                </div>
            </div>
        </template>
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="grid grid-cols-2">
                    <div class="flex justify-center">
                        <NavLink :href="route('d.c.r')">
                            <v-btn width="600" height="50" color="blue-darken-1" prepend-icon="mdi-archive">Ver todos los cursos finalizados</v-btn>
                        </NavLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
