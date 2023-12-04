<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const props = defineProps({
    departamento: {
        type: Array
    }
});

const search = ref("")

const header = [
    {key: "id", title: "ID"},
    {key: "nameDepartamento", title: "Nombre"},
    {key: "jefe_docente.nombre_completo", title: "Jefe del departamento"},
    {key: "options", title: "Opciones"},
];
</script>

<template>

    <v-data-table
        :items="props.departamento"
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
            <NavLink :href="route('edit.departamento', item.id)">
                <v-btn class="" color="success" icon>
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </NavLink>
        </template>
    </v-data-table>
<!--    <v-table fixed-header height="300px" hover>-->
<!--        <thead>-->
<!--            <tr>-->
<!--                <th>Departamento</th>-->
<!--                <th>Jefe del departamento</th>-->
<!--                <th class="text-center">Editar</th>-->
<!--            </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--            <tr v-for="c in props.departamento" :key="c.id">-->
<!--                <td>{{ c.nameDepartamento }}</td>-->
<!--                &lt;!&ndash;            <td>{{c.departamento_id }}</td>&ndash;&gt;-->
<!--                <td>-->
<!--                    <div v-if="c.jefe_docente != null">-->
<!--                        {{ c.jefe_docente.nombre_completo }}-->
<!--                    </div>-->
<!--                </td>-->
<!--                <td>-->
<!--                    <div class="flex justify-end  h-6 items-center gap-4">-->
<!--                        <NavLink :href="route('edit.departamento', c.id)">-->
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
