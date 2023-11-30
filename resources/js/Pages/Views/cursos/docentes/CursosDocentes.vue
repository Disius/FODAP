<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {FODAPStore} from "@/store/server.js";


const store = FODAPStore();

const props = defineProps({
    cursos: Array,
    auth: Object
});

const form = useForm({
    id_docente: props.auth.user.docente_id,
});
const alert = ref(false);
const search = ref("");
const color = ref("")
const message = ref("")
const snackbar = ref(false)
const timeout = ref(0);


const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 8000
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
};


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

    window.Echo.private("cursos-aceptados").listen("CursosAceptados", (event) => {
        snackEventActivator()
    })
});
</script>

<template>
    <Head title="Cursos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>
        <template v-if="props.cursos.length !== 0">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-data-iterator
                        :items="props.cursos"
                        item-value="nombreCurso"
                        :search="search"
                    >
                        <template v-slot:header>
                            <v-text-field
                                v-model="search"
                                clearable
                                density="comfortable"
                                hide-details
                                placeholder="Buscar"
                                prepend-inner-icon="mdi-magnify"
                                style="max-width: 300px;"
                                variant="solo"
                            >

                            </v-text-field>
                        </template>
                        <template v-slot:default="{items}">
                            <v-container class="pa-2 pt-15" fluid>
                                <v-row dense>
                                    <v-col v-for="item in items" :key="item.nameCarrera"
                                           cols="auto"
                                           md="6"
                                    >
                                        <v-card class="pb-3" border flat width="600">
                                            <v-list-item class="mb-2" :subtitle="item.raw.asignaturaFA">
                                                <template v-slot:title>
                                                    <strong class="text-h6 mb-2">
                                                        {{item.raw.nombreCurso}}
                                                    </strong>
                                                </template>
                                            </v-list-item>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">

                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">

                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4 pt-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">

                                                </div>
                                                <div v-if="item.raw.docente_inscrito.length > 0">
                                                    <div v-for="inscrito in item.raw.docente_inscrito">
                                                        <div v-if="inscrito.id === props.auth.user.docente_id">
                                                            <v-alert
                                                                variant="outlined"
                                                                color="success"
                                                            >
                                                                <strong class=""> Inscrito </strong>
                                                            </v-alert>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <primary-button @click="form.post(route('inscripcion.docente', curso.id), {
                                                        onSuccess: () => {
                                                           snackSuccessActivator
                                                        }
                                                    })">Inscribirse</primary-button>
                                                </div>
                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </template>
                    </v-data-iterator>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                    border="start"
                    color="info"
                    type="info"
                    title="Cursos"
                    >
                        <strong>Actualmente no hay cursos que visualizar !Pronto deberian ser agregados!</strong>
                    </v-alert>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
