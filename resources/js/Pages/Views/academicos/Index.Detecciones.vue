<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {onMounted, ref} from "vue";
import DeteccionDialog from "@/Pages/Views/dialogs/DeteccionDialogPDF.vue";


const props = defineProps({
    detecciones: {
        type: Array
    },
    carrera: {
        type: Array
    },
    auth: Object
});

const pdf_dialog = ref(false);

// const menu = [
//     {
//         name: "Generar Deteccion de Necesidades"
//     }
// ];

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
        <Head title="Detecciones"/>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Deteccion de Necesidades</h2>
            <NavLink :href="route('detecciones.create')" :active="route().current('detecciones.create')" as="button">
                <v-btn prepend-icon="mdi-pen-plus" rounded="xl" color="blue-darken-1">CREAR DETECCION DE NECESIDADES</v-btn>
            </NavLink>
        </template>

        <v-container fluid>
            <v-row justify="start">
                <v-col cols="4" align="center">
                    <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl">
                        Generar Deteccion de Necesidades
                    </v-btn>
                </v-col>
<!--                <v-col cols="6" align="center">-->
<!--                    <NavLink :href="route('detecciones.create')" :active="route().current('detecciones.create')">-->
<!--                        <v-btn rounded="xl" size="large" color="blue-darken-1">CREAR DETECCION DE NECESIDADES</v-btn>-->
<!--                    </NavLink>-->
<!--                </v-col>-->
            </v-row>
        </v-container>

        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>
        <!--Tabla-->
        <div class="">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-card elevation="0">
                        <v-table
                            fixed-header
                            height="300px"

                        >
                            <thead>
                            <tr>
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
                                v-for="deteccion in props.detecciones"
                                :key="deteccion.id"

                            >

                                <td class="v-card--hover">{{deteccion.nombreCurso}}</td>
                                <td class="v-card--hover">{{deteccion.contenidosTM}}</td>
                                <template v-if="deteccion.periodo === 1">
                                    <td class="v-card--hover">ENERO-JUNIO</td>
                                </template>
                                <template v-if="deteccion.periodo === 2">
                                    <td class="v-card--hover">AGOSTO-DICIEMBRE</td>
                                </template>
                                <td class="v-card--hover">{{deteccion.objetivoEvento}}</td>
                                <td class="ma-4 pa-4">
                                    <!-- <Estado :estadoDeteccion="props.detecciones"/> -->
                                    <template v-if="deteccion.obs === 1">
                                        <v-alert
                                            type="warning"

                                        >
                                            <p>Observaciones</p>
                                        </v-alert>
                                    </template>
                                    <template v-else-if="deteccion.obs === 0">
                                        <v-alert
                                            type="info"
                                        >
                                            <p>Sin revisar</p>
                                        </v-alert>
                                    </template>
                                    <template v-else-if="deteccion.aceptado === 1">
                                        <v-alert
                                            type="success"
                                        >
                                            <p>Aceptado</p>
                                        </v-alert>
                                    </template>
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
                    </v-card>
                </div>
            </div>
        </div>

        <v-container>
            <v-row justify="center">
                <v-col cols="12" align="center">
                    <NavLink :href="route('index.registros')" :active="route().current('index.registros')" as="button">
                        <v-btn rounded="xl" block size="x-large" color="blue-darken-1">
                            Todos los registros
                        </v-btn>
                    </NavLink>
                </v-col>
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
