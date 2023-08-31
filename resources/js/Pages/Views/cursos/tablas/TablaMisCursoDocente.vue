<script setup>

import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {computed, ref} from "vue";

const alert = ref(false);
const props = defineProps({
    curso: Object,
    user: Object
})




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
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="curso in props.curso.inscrito"
                :key="curso.id"

            >
                <td>
                    {{curso.nombreCurso}}
                </td>
                <td>
                    {{curso.objetivoEvento}}
                </td>
                <td>
                    {{curso.fecha_I}} a {{curso.fecha_F}}
                </td>
                <td>
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
                </td>
                <td>
                   {{curso.hora_I}} a {{curso.hora_F}}
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
