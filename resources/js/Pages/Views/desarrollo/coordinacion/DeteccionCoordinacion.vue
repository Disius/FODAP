<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed, onMounted, ref} from "vue";
import DeteccionDialog from '/resources/js/Pages/Views/dialogs/DeteccionDialogPDF.vue'
import {Deteccion} from "@/store/Deteccion.js";
import { TailwindPagination } from 'laravel-vue-pagination';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const store = Deteccion()
const props = defineProps({
    detecciones: Array,
    auth: Object,
    carrera: Array,
    errors: Object
});

const pdf_dialog = ref(false);
const snackCursoAdd = ref(false)
const snackCursoDelete = ref(false)
const snackDeteccionEditada = ref(false)
const search = ref("");

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

    store.getDeteccionesDesarrollo();

    window.Echo.private('deteccion_necesidades').listen('DeteccionEvent', (event) => {
        store.update_detecciones_desarrollo(event.deteccion)
        snackCursoAdd.value = true
    });
    window.Echo.private('delete-deteccion').listen('DeleteDeteccionEvent', (event) => {
        store.delete_deteccion_desarrollo(event.deteccion.id)
        snackCursoDelete.value = true
    });
    window.Echo.private('deteccion-editada').listen('DeteccionEditadaEvent', (event) => {
        snackDeteccionEditada.value = true
        console.log(event.deteccion)
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deteccion de Necesidades</h2>
        </template>

        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>

        <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <template v-if="props.detecciones.length !== 0">
                    <v-data-iterator
                        :items="props.detecciones"
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
                                style="max-width: 500px;"
                                variant="solo"
                            >

                            </v-text-field>
                        </template>
                        <template v-slot:default="{items}">
                            <v-container class="pa-2 pt-16" fluid>
                                <v-row dense>
                                    <v-col v-for="item in items" :key="item.nameCarrera"
                                           cols="auto"
                                           md="4"
                                    >
                                        <v-card class="pb-3" border flat >
                                            <v-list-item class="mb-2" :subtitle="item.raw.asignaturaFA">
                                                <template v-slot:title>
                                                    <strong class="text-h6 mb-2">
                                                        {{item.raw.nombreCurso}}
                                                    </strong>
                                                </template>
                                            </v-list-item>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <template v-if="item.raw.tipo_FDoAP === 1">
                                                        <p class="text-truncate">Formación Docente</p>
                                                    </template>
                                                    <template v-if="item.raw.tipo_FDoAP === 2">
                                                        <p>Actualización Profesional</p>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <p class="text-truncate">Dirigido a la academica de {{item.raw.carrera.nameCarrera}}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <strong>Nombre el jefe que realizo el registro del curso: {{item.raw.jefe.nombre_completo}}</strong>
                                                </div>
                                                <NavLink :href="route('show.Cdetecciones', item.raw.id)" type="button" as="button">
                                                    <v-btn
                                                        border
                                                        flat
                                                        size="small"
                                                        class="text-none"
                                                        text="Ver"
                                                        prepend-icon="mdi-eye-arrow-right-outline"
                                                    >
                                                    </v-btn>
                                                </NavLink>
                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </template>
                    </v-data-iterator>
                </template>
                <template v-else>
                    <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                            <v-alert
                                color="blue-darken-1"
                                icon="mdi-alert-circle"
                                prominent
                            >
                                Actualmente no hay cursos por realizarse, puede visualizar todos los que se llevaron acabo al presionar  "Ver todos los registros".
                            </v-alert>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <v-snackbar
            :timeout="10000"
            color="success"
            rounded="pill"
            v-model="snackCursoAdd"
            vertical
        >


            <strong>Se ha añadido un nuevo curso, recarga la pagina para visualizarlo</strong>.
        </v-snackbar>
        <v-snackbar
            :timeout="10000"
            color="success"
            rounded="pill"
            v-model="snackCursoDelete"
            vertical
        >


            <strong>Se ha eliminado un curso, recarga la pagina para visualizarlo</strong>.
        </v-snackbar>
        <v-snackbar
            :timeout="10000"
            color="success"
            rounded="pill"
            vertical
            v-model="snackDeteccionEditada"
        >


            <strong>Se ha editado un curso, recarga la pagina para visualizarlo</strong>.
        </v-snackbar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
