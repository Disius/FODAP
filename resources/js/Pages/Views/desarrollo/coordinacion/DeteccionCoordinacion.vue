<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed, onMounted, ref} from "vue";
import DeteccionDialog from '/resources/js/Pages/Views/dialogs/DeteccionDialogPDF.vue'
import {Deteccion} from "@/store/Deteccion.js";
import { TailwindPagination } from 'laravel-vue-pagination';

const store = Deteccion()
const props = defineProps({
    detecciones: Array,
    auth: Object,
    carrera: Array,
    errors: Object
});

const pdf_dialog = ref(false);



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

    store.getDeteccionesDesarrollo();

    window.Echo.private('deteccion_necesidades').listen('DeteccionEvent', (event) => {
        store.update_detecciones_desarrollo(event.deteccion)
        console.log(event.deteccion)
    })
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deteccion de Necesidades</h2>
        </template>

        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>

        <div class="py-4">
            <v-container class="mx-auto">
                <v-row justify="center">
                    <v-col cols="7" align="center">
                        <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl" block width="200" height="50">
                            Generar PDF
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <template v-if="props.detecciones.length === 0">
                <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-alert
                            color="blue-darken-1"
                            icon="mdi-alert-circle"
                            prominent
                        >
                            Actualmente no se han capturado deteccion de necesidades.
                        </v-alert>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-4 w-100">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-100">
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
                                v-for="deteccion in store.detecciones_desarrollo"
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
                                    <NavLink :href="route('show.Cdetecciones', deteccion.id)" type="button" as="button">
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
            </template>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
