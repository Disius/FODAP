<script setup>
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    curso: Array,
    user: Object
})



</script>

<template>
   <v-table fixed-header height="500px" hover>
        <thead>
            <tr>
                <th class="text-left">Nombre</th>
                <th class="text-left">Apellido Paterno</th>
                <th class="text-left">Apellido Materno</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="inscrito in props.curso.docente_inscrito"
                :key="inscrito.id"

            >
                <td>{{inscrito.nombre}}</td>
                <td>{{inscrito.apellidoPat}}</td>
                <td>{{inscrito.apellidoMat}}</td>
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
