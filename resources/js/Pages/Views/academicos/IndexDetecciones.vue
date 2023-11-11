<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import {onMounted, ref} from "vue";
import DeteccionDialog from "@/Pages/Views/dialogs/DeteccionDialogPDF.vue";
import {FODAPStore} from "@/store/server.js";
import {Deteccion} from "@/store/Deteccion.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const store = FODAPStore()
const detecciones_store = Deteccion()
const props = defineProps({
    detecciones: {
        type: Object
    },
    carrera: {
        type: Array
    },
    auth: Object,
});
const pdf_dialog = ref(false);
const snackCursoDelete = ref(false)
const snackCursoObs = ref(false)
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
    store.if_enable_fechas()
    detecciones_store.deteccionesAcademico();
    window.Echo.private('dates-enable').listen('DatesEnableEvent', (event) => {
        store.update_enable_dates(event.dates.fechas)
    });
    window.Echo.private('deteccion-observacion').listen('ObservacionEvent', (event) => {
        detecciones_store.update_detecciones_academicos(event.deteccion)
        snackCursoObs.value = true
    });
    window.Echo.private('delete-deteccion').listen('DeleteDeteccionEvent', (event) => {
        detecciones_store.delete_deteccion_academicos(event.deteccion.id)
        snackCursoDelete.value = true
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Detecciones"/>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Deteccion de Necesidades</h2>

                <div v-if="store.si_dates !== null">
                    <template v-if="store.si_dates[0] === true">
                        <NavLink :href="route('detecciones.create')" :active="route().current('detecciones.create')" as="button">
                            <v-btn prepend-icon="mdi-pen-plus" rounded="xl" color="blue-darken-1">CREAR DETECCION DE NECESIDADES</v-btn>
                        </NavLink>
                    </template>
                </div>
        </template>

        <div class="grid grid-cols-2 mt-4 mb-4">
            <div class="flex justify-center ml-5 pl-5">
                <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl" width="400">
                    Generar PDF
                </v-btn>
            </div>
            <div class="flex justify-end mr-4 pr-4">
                <div v-if="store.si_dates !== null">
                    <template v-if="store.si_dates[0]  === true">
                        <template v-if="store.si_dates[1].d === 1">
                            <v-alert
                                color="warning"
                                icon="$warning"
                                prominent
                            >
                                <strong class="text-center text-lg">
                                    Queda un {{store.si_dates[1].d}} dia y {{store.si_dates[1].h}} h para poder capturar Deteccion de Necesidades
                                </strong>
                            </v-alert>
                        </template>
                        <template v-else>
                            <v-alert
                                color="info"
                                icon="$info"
                            >
                                <strong class="text-center text-lg">
                                    Quedan {{store.si_dates[1].d}} dias y {{store.si_dates[1].h}} h para poder hacer su captura de Deteccion de Necesidades
                                </strong>
                            </v-alert>
                        </template>
                    </template>
                </div>
            </div>
        </div>

<!--        dialog-->
        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>

        <template v-if="props.detecciones.data.length !== 0">
            <!--Tabla-->
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-table
                            fixed-header
                            height="300px"

                        >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th class="text-left">
                                    Nombre del curso
                                </th>
                                <th class="text-left">
                                    Contenido tematicos
                                </th>
                                <th class="text-left">
                                    Periodo de Realización
                                </th>
                                <th class="text-left">
                                    Objetivo de la actividad o evento
                                </th>
                                <th class="text-left">Estado</th>
                                <th class="text-left">
                                    Ver
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                v-for="deteccion in props.detecciones.data"
                                :key="deteccion.id"

                            >
                                <td>{{deteccion.id}}</td>

                                <td class="">{{deteccion.nombreCurso}}</td>
                                <td class="">{{deteccion.contenidosTM}}</td>
                                <template v-if="deteccion.periodo === 1">
                                    <td class="">ENERO-JUNIO</td>
                                </template>
                                <template v-if="deteccion.periodo === 2">
                                    <td class="">AGOSTO-DICIEMBRE</td>
                                </template>
                                <td class="">{{deteccion.objetivoEvento}}</td>
                                <td class="ma-4 pa-4">
                                    <!-- <Estado :estadoDeteccion="props.detecciones"/> -->
                                    <div class="d-flex justify-center">
                                        <template v-if="deteccion.obs === 1">
                                            <v-alert
                                                type="warning"
                                                width="100"
                                                height="100"

                                            >
                                                <p>Observaciones</p>
                                            </v-alert>
                                        </template>
                                        <template v-else-if="deteccion.obs === 0">
                                            <v-alert
                                                type="info"
                                                width="200"
                                                height="150"
                                            >
                                                <p>Pendiente a revisar</p>
                                            </v-alert>
                                        </template>
                                        <template v-else-if="deteccion.aceptado === 1">
                                            <v-alert
                                                type="success"
                                                width="200"
                                                height="150"
                                            >
                                                <p>Aceptado</p>
                                            </v-alert>
                                        </template>
                                    </div>
                                </td>
                                <td>
                                    <NavLink :href="route('show.detecciones', deteccion.id)" type="button" as="button">
                                        <v-btn icon color="blue">
                                            <v-icon>mdi-eye-arrow-right-outline</v-icon>
                                        </v-btn>
                                    </NavLink>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>
                </div>
                <div class="grid grid-cols-2 mt-5">
                    <div class="flex justify-end">
                        <NavLink v-if="props.detecciones.prev_page_url" :href="props.detecciones.prev_page_url" as="button">
                            <primary-button>Anterior</primary-button>
                        </NavLink>
                    </div>
                    <div class="flex justify-start">
                        <NavLink v-if="props.detecciones.next_page_url" :href="props.detecciones.next_page_url" as="button">
                            <primary-button>Siguiente</primary-button>
                        </NavLink>
                    </div>
                </div>
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
                        Actualmente no se han capturado cursos.
                    </v-alert>
                </div>
            </div>
        </template>
        <v-snackbar
            :timeout="8000"
            color="error"
            rounded="pill"
            v-model="snackCursoDelete"
            vertical
        >


            <strong>Se ha eliminado un curso, por favor recarga la pagina para visualizarlo</strong>.
        </v-snackbar>
        <v-snackbar
            :timeout="8000"
            color="warning"
            rounded="pill"
            v-model="snackCursoObs"
            vertical
        >


            <strong>Se ha añadido una observacion a un curso, por favor recarga la pagina para visualizarlo</strong>.
        </v-snackbar>
    </AuthenticatedLayout>
</template>
