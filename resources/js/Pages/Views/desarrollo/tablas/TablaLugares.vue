<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const props = defineProps({
    lugar: {
        type: Array
    }
});


const search = ref("")

const header = [
    {key: "id", title: "ID"},
    {key: "nombreAula", title: "Nombre"},
    {key: "disponible", title: "Disponibilidad"},
    {key: "options", title: "Opciones"},
];
</script>

<template>
    <v-data-table
        :items="props.lugar"
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
            <NavLink  :href="route('edit.lugar', item.id)">
                <PrimaryButton class="bg-blue-accent-4">
                    <v-icon>mdi-pencil</v-icon>
                </PrimaryButton>
            </NavLink>
        </template>
    </v-data-table>
<!--    <v-table-->
<!--        fixed-header-->
<!--        height="300px"-->
<!--        hover-->
<!--    >-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th class="text-center">Nombre del Aula</th>-->
<!--            <th>Editar</th>-->
<!--            <th>Borrar</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--        <tr-->
<!--            v-for="l in props.lugar"-->
<!--            :key="l.id"-->
<!--        >-->
<!--            <td class="text-center">{{l.nombreAula}}</td>-->
<!--            <td>-->
<!--                <NavLink :href="route('edit.lugar', l.id)" as="button">-->
<!--                    <primary-button><v-icon>mdi-pencil</v-icon></primary-button>-->
<!--                </NavLink>-->
<!--            </td>-->
<!--            <td class="text-center">-->
<!--                <NavLink :href="route('delete.lugar', l.id)" method="delete" as="button">-->
<!--                    <v-btn color="error">-->
<!--                        Borrar-->
<!--                    </v-btn>-->
<!--                </NavLink>-->
<!--            </td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </v-table>-->
</template>


<style scoped>

</style>
