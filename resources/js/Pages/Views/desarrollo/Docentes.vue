<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, computed} from 'vue'

const props = defineProps({
    auth: Object,
    docentes: Array
});

const search = ref("");

const filterData = computed(() => {
    const busqueda = search.value.toLowerCase().trim();

    return props.docentes.filter(item => {
        return item.nombre.toLowerCase().includes(busqueda) ||
            item.apellidoPat.toLowerCase().includes(busqueda) ||
            item.apellidoMat.toLowerCase().includes(busqueda) ||
            item.nombre_completo.toLowerCase().includes(busqueda)
    });

});

onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    });
});
</script>

<template>
<AuthenticatedLayout>
    <template #header>
        <h2 class="text-lg font-medium text-gray-900">Docentes</h2>
    </template>
    <div class="grid grid-cols-2 mt-5 ml-16">
        <div class="flex justify-center w-50 ml-16">
            <v-text-field label="Buscar" variant="solo" v-model="search" prepend-icon="mdi-magnify">

            </v-text-field>
        </div>
        <div class="flex justify-center">
            <NavLink :href="route('create.docentes')">
                <v-btn prepend-icon="mdi-plus">
                    Agregar docente
                </v-btn>
            </NavLink>
        </div>
    </div>
    <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <v-table fixed-header height="400">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Editar</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="d in filterData" :key="d.id">
                    <td class="text-center">{{d.nombre}}</td>
                    <td class="text-center">{{d.apellidoPat}}</td>
                    <td class="text-center">{{d.apellidoMat}}</td>
                    <td class="text-center">
                        <NavLink :href="route('edit.docentes', d.id)" as="button">
                            <v-btn icon size="large" elevation="0">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </NavLink>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
