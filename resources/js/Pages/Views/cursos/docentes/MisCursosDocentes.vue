<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref, watch} from "vue";
import {Head, router} from "@inertiajs/vue3";
import TablaMisCursoDocente from "@/Pages/Views/cursos/tablas/TablaMisCursoDocente.vue";
import NavLink from "@/Components/NavLink.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import InfoDialog from "@/Components/InfoDialog.vue";
import {Curso} from "@/store/curso.js";

const store = Curso()
const props = defineProps({
    docente: Object,
    auth: Object,
    misCursos: {
        type: Array
    }
});
let curso_selected = ref({})
const dialogInfo = ref(false)
const search = ref()
const color = ref("")
const message = ref("")
const snackbar = ref(false)
const timeout = ref(0)
const id_ref = ref(null)
const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
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
    window.Echo.private('calificacion-update').listen('CalificacionEvent', (event) => {
        snackEventActivator()
    })

    // id_ref.value !== null ? store.get_curso_info(id_ref.value.id) : 0
});

const reloadPage = () => {
    router.reload();
    snackbar.value = false
}

function openDialog(curso){
    curso_selected.value = curso
    dialogInfo.value = true
}
watch(() => curso_selected.value, (newID) => {
    id_ref.value = newID

    store.infoCourse(id_ref.value.id)
});
</script>

<template>
    <Head title="Mis Cursos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Mis Cursos</h2>
        </template>

            <template v-if="props.misCursos.length !== 0">
                <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-data-iterator
                            :items="props.misCursos"
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
<!--                                                        <template v-if="item.raw.tipo_FDoAP === 1">-->
<!--                                                            <p class="text-truncate">Formación Docente</p>-->
<!--                                                        </template>-->
<!--                                                        <template v-if="item.raw.tipo_FDoAP === 2">-->
<!--                                                            <p>Actualización Profesional</p>-->
<!--                                                        </template>-->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-space-between px-4">
                                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">
<!--                                                        <p class="text-truncate">Dirigido a la academica de {{item.raw.carrera.nameCarrera}}</p>-->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-space-between px-4 pt-4">
                                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                        <template v-if="item.raw.calificacion === null">
                                                            <v-chip variant="flat" color="blue-darken-1" >
                                                                SIN CALIFICACION ASIGNADA
                                                            </v-chip>
                                                        </template>
                                                        <template v-if="item.raw.calificacion === 0">
                                                            <v-chip variant="flat" color="error" prepend-icon="mdi-cancel">
                                                                NO APROBADO
                                                            </v-chip>
                                                        </template>
                                                        <template v-if="item.raw.calificacion === 1">
                                                            <v-chip variant="flat" color="success" prepend-icon="mdi-check-bold">
                                                                APROBADO
                                                            </v-chip>
                                                        </template>
                                                    </div>

                                                        <v-btn
                                                            border
                                                            flat
                                                            size="large"
                                                            class="text-none"
                                                            text="Ver"
                                                            prepend-icon="mdi-eye-arrow-right-outline"
                                                            @click="openDialog(item.raw)"
                                                        >
                                                        </v-btn>

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
                            <h2>Actualmente no estas inscrito a un curso o no estan disponbles !Pronto deberias verlos disponible!</h2>
                        </v-alert>
                    </div>
                </div>
            </template>
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <v-col>
                    <NavLink :href="route('d.c.r')">
                        <v-btn width="600" height="50" color="blue-darken-1" prepend-icon="mdi-archive">Ver todos los cursos finalizados</v-btn>
                    </NavLink>
                </v-col>
            </div>
        </div>
        <CustomSnackBar :message="message" :timeout="timeout" :color="color" v-model="snackbar" @update:modelValue="snackbar = $event">
            <template v-slot:reloadingbutton>
                <div class="flex justify-start pa-1">
                    <v-btn @click="reloadPage" icon="mdi-reload"></v-btn>
                </div>
            </template>
        </CustomSnackBar>
        <InfoDialog v-model="dialogInfo" :curso="curso_selected" @update:modelValue="dialogInfo = $event"></InfoDialog>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
