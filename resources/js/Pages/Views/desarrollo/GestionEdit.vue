<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCarrera from "@/Pages/Views/desarrollo/tablas/TablaCarrera.vue";
import NavLink from "@/Components/NavLink.vue";
import {router, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref} from "vue";
import FormCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import CreateCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import TablaDepartamento from "@/Pages/Views/desarrollo/tablas/TablaDepartamento.vue";
import TablaLugares from "@/Pages/Views/desarrollo/tablas/TablaLugares.vue";
import InputLabel from "@/Components/InputLabel.vue";




const form = useForm({
    fecha_I: "",
    fecha_F: "",
});

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

function submit(){
    form.post(route('config.dates'));
    form.reset()
}


const formF = useForm({
    file: null,
    id: props.auth.user.docente_id
});

const upload_file = () => {
    form.post(route('upload.ft'), {
        forceFormData: true
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Establecer fechas para la captura de deteccion de necesidades</h2>
                </header>

                <form @submit.prevent="submit">
                    <div class="flex justify-center mr-5 items-center">
                        <InputLabel for="inicio" value="Inicia: "></InputLabel>
                        <v-text-field type="date" v-model="form.fecha_I"></v-text-field>
                    </div>
                    <div class="flex justify-center items-center">
                        <InputLabel class="text-lg" for="termino" value="Termina: "></InputLabel>
                        <v-text-field type="date" v-model="form.fecha_F"></v-text-field>
                    </div>
                    <div class="flex justify-center items-end mr-8">
                        <primary-button>Guardar</primary-button>
                    </div>
                </form>
            </div>
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
                        <PrimaryButton>Crear una nueva área</PrimaryButton>
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
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Ficha técnica</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Subir ficha técnica para editar.
                    </p>
                </header>
                <div class="grid grid-cols-2">
                    <div class="flex justify-start mt-12">
                        <v-file-input label="Ingresar Ficha Técnica" variant="solo" @input="formF.file = $event.target.files[0]"></v-file-input>
                    </div>
                    <div class="flex justify-center mt-12">
                        <v-btn color="blue-darken-1" @click="upload_file" width="500" height="50">
                            Subir
                        </v-btn>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
