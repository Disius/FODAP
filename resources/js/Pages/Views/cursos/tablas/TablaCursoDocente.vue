<script setup>

import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {computed, ref} from "vue";

const alert = ref(false);
const props = defineProps({
    cursos: Array,
    user: Object
})


const formatFechaF = computed(() => {
    let date = null
    for (let i of props.cursos){
        date = new Date(i.fecha_F).toLocaleDateString('es-MX')
    }
    return date;
});
// Computed propierties


const formatFechaI = computed(() => {
    let date = null
    for (let i of props.cursos){
        date = new Date(i.fecha_I).toLocaleDateString('es-MX')
    }
    return date;
});

const form = useForm({
    id_docente: props.user.user.docente_id,
});

const cursosFiltrados = computed(() => {
    let filtro = props.cursos.filter(e => {
        console.log(e)
    })
})

console.log(cursosFiltrados.value)
</script>

<template>
   <v-table fixed-header height="500px" hover>
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
                <th class="text-left">Inscripción
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
                    {{ formatFechaI }}  {{formatFechaF}}
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
                    <div v-for="inscrito in curso.docente_inscrito">
                         {{inscrito}}
                    </div>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
