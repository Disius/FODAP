<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const store = Curso()
const props = defineProps({
   cursos: Object,
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

    store.get_curso_desarrollo()
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de todos los cursos que se llevaron acabo</h2>
        </template>

        <template v-if="props.cursos.data.length !== 0">
            <div class="pt-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex justify-center">
                            <v-table
                                fixed-header
                                height="600px"
                            >
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        Nombre del curso
                                    </th>
                                    <th class="text-center">
                                        Contenido tematicos
                                    </th>
                                    <th class="text-center">
                                        Asignaturas que requieren actualizacion o formacion docente
                                    </th>
                                    <th class="text-center">
                                        Periodo de Realización
                                    </th>
                                    <th class="text-center">
                                        Objetivo de la actividad o evento
                                    </th>
                                    <th class="text-center">
                                        Tipo de necesidad (FORMACION DOCENTE O ACTUALIZACIÓN PROFESIONAL)
                                    </th>
                                    <th class="text-left">
                                        Revisar deteccion de necesidades
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="deteccion in props.cursos.data"
                                    :key="deteccion.id"
                                >
                                    <td>{{deteccion.nombreCurso}}</td>
                                    <td>{{deteccion.contenidosTM}}</td>
                                    <td>{{deteccion.asignaturaFA}}</td>
                                    <template v-if="deteccion.periodo === 1">
                                        <td>ENERO-JUNIO</td>
                                    </template>
                                    <template v-else>
                                        <td>AGOSTO-DICIEMBRE</td>
                                    </template>
                                    <td>{{deteccion.objetivoEvento}}</td>
                                    <template v-if="deteccion.tipo_FDoAP === 1">
                                        <td>FORMACIÓN DOCENTE</td>
                                    </template>
                                    <template v-else>
                                        <td>ACTUALIZACIÓN PROFESIONAL</td>
                                    </template>
                                    <td>
                                        <NavLink :href="route('index.desarrollo.inscritos', deteccion.id)" type="button" as="button">
                                            <v-btn icon color="blue">
                                                <v-icon>mdi-eye-arrow-right-outline</v-icon>
                                            </v-btn>
                                        </NavLink>
                                    </td>
                                </tr>
                                </tbody>
                            </v-table>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 mt-5">
                        <div class="flex justify-end">
                            <NavLink v-if="props.cursos.prev_page_url" :href="props.cursos.prev_page_url" as="button">
                                <primary-button>Anterior</primary-button>
                            </NavLink>
                        </div>
                        <div class="flex justify-start">
                            <NavLink v-if="props.cursos.next_page_url" :href="props.cursos.next_page_url" as="button">
                                <primary-button>Siguiente</primary-button>
                            </NavLink>
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
