<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";



const search = ref("")

const header = [
    {key: "id", title: "ID"},
    {key: "nameCarrera", title: "Nombre"},
    {key: "departamento.nameDepartamento", title: "Departamento a cargo"},
    {key: "apellidoMat", title: "Presidente de la academia"},
    {key: "options", title: "Opciones"},
];
const props = defineProps({
    carrera: {
        type: Array
    }
});
</script>

<template>
    <v-data-table
    :items="props.carrera"
    :headers="header"
    fixed-header
    next-icon="mdi-arrow-right-bold-circle"
    prev-icon="mdi-arrow-left-bold-circle"
    items-per-page="5"
    items-per-page-text="Paginas"
    >
        <template v-slot:item.options="{item}">
            <NavLink :href="route('edit.carrera', item.id)">
                <PrimaryButton class="bg-blue-accent-4">
                    <v-icon>mdi-pencil</v-icon>
                </PrimaryButton>
            </NavLink>
        </template>
    </v-data-table>
<!--    <v-table fixed-header height="300px" hover>-->
<!--        <thead>-->
<!--            <tr>-->
<!--                <th>Carrera</th>-->
<!--                <th>Departamento a cargo</th>-->
<!--                <th>Presidente de la academia</th>-->
<!--                <th class="text-center">Editar</th>-->
<!--            </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--            <tr v-for="c in props.carrera" :key="c.id">-->
<!--                <td>{{ c.nameCarrera }}</td>-->
<!--                &lt;!&ndash;            <td>{{c.departamento_id }}</td>&ndash;&gt;-->
<!--                <td>-->
<!--                    <template v-if="c.departamento !== null">-->
<!--                        {{ c.departamento.nameDepartamento }}-->
<!--                    </template>-->
<!--                </td>-->
<!--                <td>-->
<!--                    <template v-if="c.presidente_academia != null">-->
<!--                        {{ c.presidente_academia.nombre_completo }}-->
<!--                    </template>-->
<!--                </td>-->
<!--                <td>-->
<!--                    <div class="flex justify-end  h-4 items-center gap-4">-->
<!--                        <NavLink :href="route('edit.carrera', c.id)">-->
<!--                            <PrimaryButton class="bg-blue-accent-4">-->
<!--                                <v-icon>mdi-pencil</v-icon>-->
<!--                            </PrimaryButton>-->
<!--                        </NavLink>-->
<!--                    </div>-->
<!--                </td>-->
<!--            </tr>-->
<!--        </tbody>-->
<!--    </v-table>-->
</template>

<style scoped></style>
