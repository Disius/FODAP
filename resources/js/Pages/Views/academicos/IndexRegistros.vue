<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    detecciones: {
        type: Array
    },
    auth: Object,
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registros de cursos</h2>
        </template>

        <template v-if="props.detecciones.length !== 0">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
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
                                <td>
                                    <NavLink :href="route('show.inscritos.academicos', deteccion.id)" type="button" as="button">
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
        </template>
        <template v-else>
            <div class="mt-10 pt-10 mx-auto sm:px-6 lg:px-8 space-y-6">
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
