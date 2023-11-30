<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, computed} from 'vue'

const props = defineProps({
    auth: Object,
    docentes: Object
});

const search = ref("");


const header = [
    {key: "nombre", title: "Nombre"},
    {key: "apellidoPat", title: "Apellido Paterno"},
    {key: "apellidoMat", title: "Apellido Materno"},
    {key: "options", title: "Opciones"},
];
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
    <div class="grid grid-cols-3 mt-5 ml-16">
        <div class="flex justify-center">
            <NavLink :href="route('create.docentes.academicos')" as="button">
                <v-btn prepend-icon="mdi-plus">
                    Agregar docente
                </v-btn>
            </NavLink>
        </div>
    </div>
    <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <v-text-field
                        v-model="search"
                        label="Search"
                        prepend-icon="mdi-magnify"
                        variant="solo"
                    ></v-text-field>
                    <v-data-table :headers="header" :items="props.docentes" :search="search"
                                  fixed-header
                                  next-icon="mdi-arrow-right-bold-circle"
                                  prev-icon="mdi-arrow-left-bold-circle"
                                  items-per-page="5"
                                  items-per-page-text="Paginas"
                    >
                        <template v-slot:item.options="{item}">
                            <NavLink :href="route('edit.docentes.academicos', item.id)" as="button">
                                <v-btn icon size="large" elevation="0">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </NavLink>
                        </template>
                    </v-data-table>
                </div>
        </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
