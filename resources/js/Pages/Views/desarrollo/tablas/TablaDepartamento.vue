<template>
    <v-table
        fixed-header
        height="300px"
        hover
    >
        <thead>
        <tr>
            <th>Departamento</th>
            <th>Jefe del departamento</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="c in props.departamento"
            :key="c.id"
        >
            <td>{{c.nameDepartamento}}</td>
<!--            <td>{{c.departamento_id }}</td>-->
            <td>
                {{c.jefe_id}}
            </td>
            <td>
                <div class="flex justify-end  h-6 items-center gap-4">
                    <NavLink :href="route('edit.departamento', c.id)">
                        <PrimaryButton class="bg-blue-accent-4">Editar departamento</PrimaryButton>
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
   departamento: {
       type: Array
   }
});
</script>

<style scoped>

</style>
