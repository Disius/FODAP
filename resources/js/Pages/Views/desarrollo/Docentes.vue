<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted} from "vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, computed} from 'vue'
import CreateDocenteA from "@/Pages/Views/academicos/docentes/CreateDocenteA.vue";
import Loading from "@/Components/Loading.vue";

const props = defineProps({
    auth: Object,
    docentes: Array,
    posgrado: {
        type: Array,
    },
    puesto: {
        type: Array
    },
    tipo_plaza: {
        type: Array,
    },
    carrera: Array,
    departamento: Array,
});

const search = ref("");
const dialog = ref(false)
const loading = ref(false)
const snackbar = ref();
const message = ref("")
const color = ref("")
const timeout = ref()

const header = [
    {key: "nombre", title: "Nombre"},
    {key: "apellidoPat", title: "Apellido Paterno"},
    {key: "apellidoMat", title: "Apellido Materno"},
    {key: "options", title: "Editar"},
    {key: "delete", title: "Eliminar"},
];

const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
async function submitDocente(form){
    loading.value = true
    try {
        form.post(route('store.docentes'), {
            onSuccess: () => {
                snackSuccessActivator()
                form.reset()
                dialog.value = false
                loading.value = false
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    }catch (e) {
        snackErrorActivator()
    }
}
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
        <div class="flex justify-center">
            <v-btn prepend-icon="mdi-plus" @click="dialog = true" color="blue-darken-1">
                Agregar docente
            </v-btn>
            <create-docente-a :tipo_plaza="props.tipo_plaza" :puesto="props.puesto" :posgrado="props.posgrado"
                              :departamento="props.departamento" :carrera="props.carrera" :auth="props.auth"
                                v-model="dialog" @docente-add="submitDocente" @update:modelValue="dialog = $event"
            >

            </create-docente-a>
        </div>
    </div>
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
                    <NavLink :href="route('edit.docentes', item.id)" as="button">
                        <v-btn icon size="large" elevation="0">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                    </NavLink>
                </template>
            </v-data-table>
        </div>
    </div>
    <Loading v-model="loading" @update:modelValue="loading = $event">

    </Loading>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
