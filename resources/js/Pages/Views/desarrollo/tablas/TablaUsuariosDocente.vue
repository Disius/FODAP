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

const search = ref("")

const header = [
    {key: "email", title: "Correo Institucional"},
    {key: "nombre", title: "Nombre del usuario"},
    {key: "departamento.nameDepartamento", title: "Usuario adscrito a"},
    {key: "edit", title: "Editar Usuario"},
    {key: "delete", title: "Eliminar usuario"},
    {key: "permiso", title: "Permitir actualizar email u contraseña"},
    {key: "revocar", title: "Revocar permiso"},
];

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
    <v-data-table
        :items="usersA"
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
        <template v-slot:item.nombre="{item}">
            <div v-if="item.docente !== null">
                {{item.docente.nombre_completo}}
            </div>
        </template>
        <template v-slot:item.edit="{item}">
            <NavLink :href="route('edit.user', item.id)" as="button">
                <primary-button>
                    <v-icon>mdi-pencil</v-icon>
                </primary-button>
            </NavLink>
        </template>
        <template v-slot:item.delete="{item}">
            <DeleteUserSelectForm :user="wich_user(item)"></DeleteUserSelectForm>
        </template>
        <template v-slot:item.permiso="{item}">
            <NavLink :href="route('permiso.edit', item.id)" as="button" method="post">
                <v-btn height="35" color="info">
                    <v-icon>mdi-check</v-icon>
                </v-btn>
            </NavLink>
        </template>
        <template v-slot:item.revocar="{item}">
        <div v-if="item.permissions.length > 0">
            <td class="text-center">
                <NavLink :href="route('permiso.revoke', item.id)" as="button" method="post">
                    <v-btn width="250" height="35" color="error">
                        <v-icon>mdi-cancel</v-icon>
                    </v-btn>
                </NavLink>
            </td>
        </div>
    </template>

    </v-data-table>
</template>


<style scoped>

</style>
