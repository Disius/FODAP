<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed, ref} from "vue";
import DeleteUserSelectForm from "@/Pages/Views/desarrollo/forms/DeleteUserSelectForm.vue";




const props = defineProps({
    users: {
        type: Array
    },
    auth: {
        type: Object
    },

});

const usersA = computed(() => {
    return props.users.filter(user => {
        return user.role === 4
    })
});
const wich_user = (user) => {
    return user;
}
</script>

<template>
    <v-table
        fixed-header
        height="300px"
        hover
    >
        <thead>
        <tr>
            <th class="text-center">Correo Institucional</th>
            <th class="text-center">Nombre del usuario</th>
            <th class="text-center">Usuario adscrito a</th>
            <th class="text-center">Editar usuario</th>
            <th class="text-center">Eliminar usuario</th>
            <th class="text-center">Permitir actualizar correo institucional u contraseña</th>
            <th class="text-center">Revocar permisos</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="u in usersA"
            :key="u.id"
        >
            <td class="text-center">{{u.email}}</td>
            <template v-if="u.docente !== null">
                <td class="text-center">{{u.docente.nombre_completo}}</td>
            </template>
            <template v-else>
                <td></td>
            </template>
            <td class="text-center">{{u.departamento.nameDepartamento}}</td>
            <td class="text-center">
                <NavLink :href="route('edit.user', u.id)" as="button">
                    <primary-button>Editar</primary-button>
                </NavLink>
            </td>
            <td class="text-center">
                <DeleteUserSelectForm :user="wich_user(u)"></DeleteUserSelectForm>
            </td>
            <td class="text-center">
                <NavLink :href="route('permiso.edit', u.id)" as="button" method="post">
                    <v-btn width="150" height="35" color="info" prepend-icon="mdi-check">Permiso</v-btn>
                </NavLink>
            </td>
            <template v-if="u.permissions.length > 0">
                <td class="text-center">
                    <NavLink :href="route('permiso.revoke', u.id)" as="button" method="post">
                        <v-btn width="250" height="35" color="error" prepend-icon="mdi-cancel">Revocar permiso</v-btn>
                    </NavLink>
                </td>
            </template>
        </tr>
        </tbody>
    </v-table>
</template>


<style scoped>

</style>
