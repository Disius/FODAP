<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    detecciones: {
        type: Object
    },
    auth: Object,
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registros de cursos</h2>
        </template>

        <template v-if="props.detecciones.data.length !== 0">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                                v-for="deteccion in props.detecciones.data"
                                :key="deteccion.id"

                            >

                                <td class="">{{deteccion.nombreCurso}}</td>
                                <td class="">{{deteccion.contenidosTM}}</td>
                                <template v-if="deteccion.periodo === 1">
                                    <td class="">ENERO-JUNIO</td>
                                </template>
                                <template v-if="deteccion.periodo === 2">
                                    <td class="">AGOSTO-DICIEMBRE</td>
                                </template>
                                <td class="">{{deteccion.objetivoEvento}}</td>
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
