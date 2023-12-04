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
        <template v-slot:no-data>
            <v-alert :value="true" color="warning">
                <v-icon left color="white">warning</v-icon
                >No se encontraron datos
            </v-alert>
        </template>
        <template v-slot:item.options="{item}">
            <NavLink :href="route('edit.carrera', item.id)">
                <v-btn class="" color="success" icon>
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </NavLink>
        </template>
    </v-data-table>
</template>

<style scoped></style>
