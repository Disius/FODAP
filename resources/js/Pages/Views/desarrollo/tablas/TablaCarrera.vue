<template>
    <v-table fixed-header height="300px" hover>
        <thead>
            <tr>
                <th>Carrera</th>
                <th>Departamento a cargo</th>
                <th>Presidente de la academia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="c in props.carrera" :key="c.id">
                <td>{{ c.nameCarrera }}</td>
                <!--            <td>{{c.departamento_id }}</td>-->
                <td>
                    <template v-if="c.departamento !== null">
                        {{ c.departamento.nameDepartamento }}
                    </template>
                </td>
                <td>
                    <template v-if="c.presidente_academia != null">
                        {{ c.presidente_academia.nombre_completo }}
                    </template>
                </td>
                <td>
                    <div class="flex justify-end  h-4 items-center gap-4">
                        <NavLink :href="route('edit.carrera', c.id)">
                            <PrimaryButton class="bg-blue-accent-4">Editar carrera</PrimaryButton>
                        </NavLink>
                    </div>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    carrera: {
        type: Array
    }
});
</script>

<style scoped></style>
