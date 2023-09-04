<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    lugar: {
        type: Array
    }
});
</script>

<template>
    <v-table
        fixed-header
        height="300px"
        hover
    >
        <thead>
        <tr>
            <th>Nombre del Aula</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="l in props.lugar"
            :key="l.id"
        >
            <td>{{l.nombreAula}}</td>
            <td>
                <NavLink :href="route('edit.lugar', l.id)" as="button">
                    <primary-button>Editar</primary-button>
                </NavLink>
            </td><td>
                <NavLink :href="route('delete.lugar', l.id)" method="delete" as="button">
                    <v-btn color="error">
                        Borrar
                    </v-btn>
                </NavLink>
            </td>
        </tr>
        </tbody>
    </v-table>
</template>


<style scoped>

</style>
