<script setup>

import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    detecciones: Array,
})
</script>

<template>

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
                v-for="deteccion in detecciones"
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
</template>

<style>

</style>
