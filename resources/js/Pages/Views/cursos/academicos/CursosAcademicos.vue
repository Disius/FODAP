<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import TablaCursoAcademico from "@/Pages/Views/cursos/tablas/TablaCursoAcademico.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const curso_store = Curso()

const props = defineProps({
    cursos: Array,
    auth: Object,
});

const search = ref("");
const message = ref("")
const color = ref()
const snackbar = ref(false)
const timeout = ref(0)
const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 5000
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

    window.Echo.private('cursos-aceptados').listen('CursosAceptados', (event) => {
        snackEventActivator()
    });

});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>
        <CustomSnackBar :message="message" :color="color" v-model="snackbar" :timeout="timeout" @update:modelValue="snackbar = $event"/>

        <template v-if="props.cursos.length !== 0">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-3 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-virtual-scroll
                        :items="props.cursos"
                        height="300"
                        item-height="50"
                        class="mt-4"

                    >
                        <template v-slot:default="{ item }">
                            <v-list-item>
                                <template v-slot:prepend>
                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                        <template v-if="item.estado === 0">
                                            <v-chip variant="flat" color="warning" prepend-icon="$info">
                                                Curso por realizar
                                            </v-chip>
                                        </template>
                                        <template v-else>
                                            <v-chip variant="flat" color="success" prepend-icon="$info">
                                                En curso
                                            </v-chip>
                                        </template>
                                    </div>
                                </template>

                                <div class="ml-8">
                                    <v-list-item-title>{{ item.nombreCurso }}</v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{item.departamento.nameDepartamento}}
                                    </v-list-item-subtitle>
                                    <v-list-item-action><strong>{{item.jefe.nombre_completo}}</strong></v-list-item-action>
                                </div>
                                <template v-slot:append>
                                    <NavLink :href="route('show.inscritos.academicos', item.id)" type="button" as="button">
                                        <v-btn
                                            border
                                            flat
                                            size="large"
                                            class="text-none"
                                            text="Ver"
                                            prepend-icon="mdi-eye-arrow-right-outline"
                                        >
                                        </v-btn>
                                    </NavLink>
                                </template>
                            </v-list-item>
                        </template>
                    </v-virtual-scroll>
                </div>
                <div class="grid grid-cols-2 mt-5">
                    <div class="flex justify-end">
                        <NavLink v-if="props.cursos.prev_page_url" :href="props.cursos.prev_page_url" as="button">
                            <primary-button>Anterior</primary-button>
                        </NavLink>
                    </div>
                    <div class="flex justify-start">
                        <NavLink v-if="props.cursos.next_page_url" :href="props.cursos.next_page_url" as="button">
                            <primary-button>Siguiente</primary-button>
                        </NavLink>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                        color="blue-darken-1"
                        icon="mdi-alert-circle"
                        height="100"
                    >
                        Actualmente no se han aceptado cursos.
                    </v-alert>
                </div>
            </div>
        </template>

        <v-container class="mt-3">
            <v-row justify="center">
                <v-col cols="12" align="center">
                    <NavLink :href="route('index.registros')" :active="route().current('index.registros')" as="button">
                        <v-btn rounded="xl" block size="x-large" color="blue-darken-1" prepend-icon="mdi-archive">
                            Todos los registros
                        </v-btn>
                    </NavLink>
                </v-col>
            </v-row>
        </v-container>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
