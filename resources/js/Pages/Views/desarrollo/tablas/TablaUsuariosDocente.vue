<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed} from "vue";
import DeleteUserSelectForm from "@/Pages/Views/desarrollo/forms/DeleteUserSelectForm.vue";

const props = defineProps({
    users: {
        type: Array
    }
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
            <th class="text-center">Editar usuario</th>
            <th class="text-center">Eliminar usuario</th>
            <th class="text-center">Permitir actualizar correo institucional u contraseña</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="u in usersA"
            :key="u.id"
        >
            <td class="text-center">{{u.email}}</td>
            <td class="text-center">
                <NavLink :href="route('edit.lugar', u.id)" as="button">
                    <primary-button>Editar</primary-button>
                </NavLink>
            </td>
            <td class="text-center">
                <DeleteUserSelectForm :user="wich_user(u)"></DeleteUserSelectForm>
            </td>
            <td class="text-center">
                <v-btn width="150" height="35" color="info" prepend-icon="mdi-check">Permiso</v-btn>
            </td>
        </tr>
        </tbody>
    </v-table>
</template>


<style scoped>

</style>
