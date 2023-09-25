<script setup>
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    cursos: Array,
    user: Object
})


// const formatFechaF = computed(() => {
//     let date = null
//     for (let i of props.cursos){
//         date = new Date(i.fecha_F).toLocaleDateString('es-MX')
//     }
//     return date;
// });
// // Computed propierties
//
//
// const formatFechaI = computed(() => {
//     let date = null
//     for (let i of props.cursos){
//         date = new Date(i.fecha_I).toLocaleDateString('es-MX')
//     }
//     return date;
// });




</script>

<template>
   <v-table fixed-header height="400px">
        <thead>
            <tr>
                <th class="text-left">Nombre de los
                    Cursos</th>
                <th class="text-left">Objetivo</th>
                <th class="text-left">Fecha de
                    realización</th>
                <th class="text-left">Lugar
                    (presencial
                    o virtual)
                </th>
                <th class="text-left">Horario
                </th>
                <th class="text-left">No. de
                                horas
                                x
                                Curso
                </th>
                <th class="text-left">
                    Facilitador (a)
                </th>
                <th class="text-left">Dirigido a:</th>
                <th class="text-left">Observaciones
                </th>
                <th>
                    Estado
                </th>
                <th class="text-left">Ver Inscritos

                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="curso in props.cursos"
                :key="curso.id"

            >
                <td class="v-card--hover">
                    {{ curso.nombreCurso }}
                </td>
                <td class="v-card--hover">
                    {{ curso.objetivoEvento }}
                </td>
                <td class="v-card--hover">
                    {{ curso.fecha_I }} - {{curso.fecha_F}}
                </td>
                <td class="v-card--hover">
                    <template v-if="curso.modalidad === 1">
                        <span>Virtual</span>
                    </template>
                    <template v-if="curso.modalidad === 2">
                        <span>Presencial</span>
                    </template>
                    <template v-if="curso.modalidad === 3">
                        <span>Hibrído</span>
                    </template>
                </td>
                <td class="v-card--hover">
                    {{ curso.hora_I }} a {{curso.hora_F}}
                </td>
                <td class="v-card--hover">
                    {{curso.total_horas}}
                </td>
                <td class="v-card--hover">
                    <template
                        v-for="facilitador in curso.deteccion_facilitador"
                    >
                        <br> • {{facilitador.nombre}} {{facilitador.apellidoPat}} {{facilitador.apellidoMat}}
                    </template>
                </td>
                <td class="v-card--hover">
                    {{ curso.carrera.nameCarrera }}
                </td>
                <td class="v-card--hover">
                    {{ curso.observaciones }}
                </td>
                <td class="v-card--hover">
                    <div v-if="curso.estado === 0">
                        <v-alert min-width="100" color="warning">Por realizarse</v-alert>
                    </div>
                    <div v-else-if="curso.estado === 1">
                        <v-alert min-width="100" color="success">En curso</v-alert>
                    </div>
                    <div v-else>
                        <v-alert min-width="150" color="error">Finalizado</v-alert>
                    </div>
                </td>
                <td class="v-card--hover">
                    <NavLink :href="route('index.desarrollo.inscritos', curso.id)" type="button" as="button">
                        <v-btn icon color="blue">
                            <v-icon>mdi-eye-arrow-right-outline</v-icon>
                        </v-btn>
                    </NavLink>
                </td>

            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
