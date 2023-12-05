<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import {onMounted, ref} from "vue";
import DeteccionDialog from "@/Pages/Views/dialogs/DeteccionDialogPDF.vue";
import {FODAPStore} from "@/store/server.js";
import {Deteccion} from "@/store/Deteccion.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const store = FODAPStore()
const detecciones_store = Deteccion()
const props = defineProps({
    detecciones: {
        type: Array
    },
    carrera: {
        type: Array
    },
    auth: Object,
});
const pdf_dialog = ref(false);
const snackbar = ref(false);
const color = ref("")
const message = ref("")
const timeout = ref(0)
const search = ref()


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
    })
    store.if_enable_fechas()
    detecciones_store.deteccionesAcademico();
    window.Echo.private('dates-enable').listen('DatesEnableEvent', (event) => {
        store.update_enable_dates(event.dates.fechas)
    });
    window.Echo.private('deteccion-observacion').listen('ObservacionEvent', (event) => {
        snackEventActivator()
    });
    window.Echo.private('delete-deteccion').listen('DeleteDeteccionEvent', (event) => {
        snackEventActivator()
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Detecciones"/>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Deteccion de Necesidades</h2>

                <div v-if="store.si_dates !== null">
                    <template v-if="store.si_dates[0] === true">
                        <NavLink :href="route('detecciones.create')" :active="route().current('detecciones.create')" as="button">
                            <v-btn prepend-icon="mdi-pen-plus" rounded="xl" color="blue-darken-1">CREAR DETECCION DE NECESIDADES</v-btn>
                        </NavLink>
                    </template>
                </div>
        </template>

        <div class="grid grid-cols-2 mt-4 mb-4">
            <template v-if="props.detecciones.length === 0">
                <div class="flex justify-center ml-5 pl-5">
                    <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl" width="400">
                        Generar PDF
                    </v-btn>
                </div>
            </template>
            <div class="flex justify-end mr-2 pr-2">
                <div v-if="store.si_dates !== null">
                    <template v-if="store.si_dates[0]  === true">
                        <template v-if="store.si_dates[1].d === 1">
                            <v-alert
                                color="warning"
                                icon="$warning"
                                prominent
                            >
                                <strong class="text-center text-lg">
                                    Queda un {{store.si_dates[1].d}} dia y {{store.si_dates[1].h}} h para poder capturar Deteccion de Necesidades
                                </strong>
                            </v-alert>
                        </template>
                        <template v-if="store.si_dates[1].d === 0">
                            <v-alert
                                color="error"
                                icon="$error"
                                prominent
                            >
                                <strong class="text-center text-lg">
                                    Quedan {{store.si_dates[1].h}} h para poder capturar Deteccion de Necesidades
                                </strong>
                            </v-alert>
                        </template>
                        <template v-else>
                            <v-alert
                                color="info"
                                icon="$info"
                            >
                                <strong class="text-center text-lg">
                                    Quedan {{store.si_dates[1].d}} dias y {{store.si_dates[1].h}} h para poder hacer su captura de Deteccion de Necesidades
                                </strong>
                            </v-alert>
                        </template>
                    </template>
                </div>
            </div>
        </div>

<!--        dialog-->
        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>

        <template v-if="props.detecciones.length !== 0">
            <!--Tabla-->
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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

                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4 pt-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <template v-if="item.raw.obs === 1">
                                                        <v-chip variant="flat" color="warning" prepend-icon="$info">
                                                            Observacion
                                                        </v-chip>
                                                    </template>
                                                    <template v-else-if="item.raw.obs === 0">
                                                        <v-chip variant="flat" color="info" prepend-icon="$info">
                                                            Pendiente a revisar
                                                        </v-chip>
                                                    </template>
                                                </div>
                                                <NavLink :href="route('show.detecciones', item.raw.id)" type="button" as="button">
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
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                        color="blue-darken-1"
                        icon="mdi-alert-circle"
                        prominent
                    >
                        Actualmente no se han capturado cursos.
                    </v-alert>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
