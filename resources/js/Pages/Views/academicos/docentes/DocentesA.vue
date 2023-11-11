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

const filterData = computed(() => {
    const busqueda = search.value.toLowerCase().trim();

    return props.docentes.data.filter(item => {
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
    <div class="grid grid-cols-3 mt-5 ml-16">
        <div class="flex justify-center w-90 ml-16">
            <v-text-field label="Buscar" variant="solo" v-model="search" prepend-icon="mdi-magnify">

            </v-text-field>
        </div>
        <div class="flex justify-start ml-4">
            <v-tooltip location="right" class="ml-16">
                <template v-slot:activator="{ props }">
                    <v-btn icon color="blue-darken-1" v-bind="props">
                        <v-icon>
                            mdi-help
                        </v-icon>
                    </v-btn>
                </template>
                <span>Tenga en cuenta que filtrara solo los datos que aparecen paginados.</span>
            </v-tooltip>
        </div>
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
                        <NavLink :href="route('edit.docentes.academicos', d.id)" as="button">
                            <v-btn icon size="large" elevation="0">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </NavLink>
                    </td>
                </tr>
                </tbody>
            </v-table>
            <div class="grid grid-cols-2 mt-5">
                <div class="flex justify-end">
                    <NavLink v-if="props.docentes.prev_page_url" :href="props.docentes.prev_page_url" as="button">
                        <primary-button>Anterior</primary-button>
                    </NavLink>
                </div>
                <div class="flex justify-start">
                    <NavLink v-if="props.docentes.next_page_url" :href="props.docentes.next_page_url" as="button">
                        <primary-button>Siguiente</primary-button>
                    </NavLink>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
