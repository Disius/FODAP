<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import TablaCursoAcademico from "@/Pages/Views/cursos/tablas/TablaCursoAcademico.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const curso_store = Curso()

const props = defineProps({
    cursos: Object,
    auth: Object,
});
const snackCursoAceptado = ref(false);

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
    curso_store.get_cursos_academicos()
    window.Echo.private('cursos-aceptados').listen('CursosAceptados', (event) => {
        snackCursoAceptado.value = true
        curso_store.curso_aceptado_update(event.curso)
    });

});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>
        <v-snackbar
            :timeout="8000"
            color="info"
            rounded="pill"
            v-model="snackCursoAceptado"
            vertical
        >


            <strong>Se ha aceptado un curso, por favor recarga la pagina para visualizarlo</strong>.
        </v-snackbar>

        <template v-if="props.cursos.data.length !== 0">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-3 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-table fixed-header height="500px" hover>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th class="text-left">Nombre de los
                                Cursos</th>
                            <th class="text-left">Objetivo</th>
                            <th class="text-left">Fecha de
                                realización</th>
                            <th class="text-left">Lugar
                                (presencial
                                o virtual)
                            </th>
                            <th class="text-left">Horario
                            </th>
                            <th class="text-left">No. de
                                horas
                                x
                                Curso
                            </th>
                            <th class="text-left">
                                Facilitador (a)
                            </th>
                            <th class="text-left">Dirigido a:</th>
                            <th class="text-left">Observaciones
                            </th>
                            <th>Estado</th>
                            <th class="text-left">
                                Ver Inscritos
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="curso in props.cursos.data"
                            :key="curso.id"

                        >
                            <td>{{curso.id}}</td>
                            <td class="">
                                {{ curso.nombreCurso }}
                            </td>
                            <td class="">
                                {{ curso.objetivoEvento }}
                            </td>
                            <td class="">
                                {{ curso.fecha_I }} al {{curso.fecha_F}}
                            </td>
                            <td class="">
                                <template v-if="curso.modalidad === 1">
                                    <span>Virtual</span>
                                </template>
                                <template v-if="curso.modalidad === 2">
                                    <span>Presencial</span>
                                </template>
                                <template v-if="curso.modalidad === 3">
                                    <span>Hibrído</span>
                                </template>
                            </td>
                            <td class="">
                                {{ curso.hora_I }} a {{curso.hora_F}}
                            </td>
                            <td class="">
                                {{curso.total_horas}}
                            </td>
                            <td class="">
                                <template
                                    v-for="facilitador in curso.deteccion_facilitador"
                                >
                                    <br> • {{facilitador.nombre}} {{facilitador.apellidoPat}} {{facilitador.apellidoMat}}
                                </template>
                            </td>
                            <td class="">
                                {{ curso.carrera.nameCarrera }}
                            </td>
                            <td class="">
                                {{ curso.observaciones }}
                            </td>
                            <td width="200">
                                <div v-if="curso.estado === 0">
                                    <v-alert width="100" height="100" color="warning">Por realizarse</v-alert>
                                </div>
                                <div v-else-if="curso.estado === 1">
                                    <v-alert color="success">En curso</v-alert>
                                </div>
                                <div v-else-if="curso.estado === 2">
                                    <v-alert color="error">Finalizado</v-alert>
                                </div>
                            </td>
                            <td class="">
                                <NavLink :href="route('show.inscritos.academicos', curso.id)" type="button" as="button">
                                    <v-btn icon color="blue">
                                        <v-icon>mdi-eye-arrow-right-outline</v-icon>
                                    </v-btn>
                                </NavLink>
                            </td>

                        </tr>
                        </tbody>
                    </v-table>
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
