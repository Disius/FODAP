<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCarrera from "@/Pages/Views/desarrollo/tablas/TablaCarrera.vue";
import NavLink from "@/Components/NavLink.vue";
import {router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref} from "vue";
import FormCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import CreateCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import TablaDepartamento from "@/Pages/Views/desarrollo/tablas/TablaDepartamento.vue";
import TablaLugares from "@/Pages/Views/desarrollo/tablas/TablaLugares.vue";




const dialog = ref(false);

const props = defineProps({
    docente: {
        type: Array
    },
    carrera: {
        type: Array
    },
    departamento: {
        type: Array,
    },
    auth: Object,
    lugar: Array,
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Carreras</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Actualizar o añadir carreras
                    </p>
                </header>
                <TablaCarrera :carrera="props.carrera"></TablaCarrera>
                <div class="flex justify-end mr-12 mt-12 h-6 items-center gap-4">
                    <NavLink :href="route('create.carrera')">
                        <PrimaryButton>Crear una carrera</PrimaryButton>
                    </NavLink>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Departamentos</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Actualizar o añadir departamentos
                    </p>
                </header>
                <TablaDepartamento :departamento="props.departamento"></TablaDepartamento>
                <div class="flex justify-end mr-12 mt-12 h-6 items-center gap-4">
                    <NavLink :href="route('create.departamento')">
                        <PrimaryButton>Crear un departamento</PrimaryButton>
                    </NavLink>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Lugar</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Lugares donde se llevan a cabo cursos y actividades.
                    </p>
                </header>
                <TablaLugares :lugar="props.lugar"></TablaLugares>
                <div class="flex justify-end mt-8 mr-12 items-center">
                    <NavLink :href="route('create.lugar')" as="button">
                        <primary-button>Crear</primary-button>
                    </NavLink>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
