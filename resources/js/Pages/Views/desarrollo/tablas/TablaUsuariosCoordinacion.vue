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
        return user.role === 2
    })
});

const wich_user = (user) => {
    return user;
}
</script>

<template>
    <v-table
        fixed-header
        height="150px"
        hover
    >
        <thead>
        <tr>
            <th class="text-center">Correo Institucional</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Borrar</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="u in usersA"
            :key="u.id"
        >
            <td class="text-center"> {{u.email}}</td>
            <td class="text-center">
                    <NavLink :href="route('edit.user', u.id)" as="button">
                        <primary-button>
                            <v-icon>
                                mdi-pencil
                            </v-icon>
                        </primary-button>
                    </NavLink>
            </td>
            <td class="text-center">
                <DeleteUserSelectForm :user="wich_user(u)"></DeleteUserSelectForm>
            </td>
        </tr>
        </tbody>
    </v-table>
</template>


<style scoped>

</style>
