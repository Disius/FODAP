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
    <Head title="Cursos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>
        <template v-if="props.cursos.length !== 0">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-table fixed-header height="500px" hover class="text-caption">
                        <thead>
                        <tr>
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
                            <th class="text-left">Estado del curso
                            </th>
                            <th class="text-left">Inscripción
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="curso in props.cursos"
                            :key="curso.id"

                        >
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
                            <td class="">
                                <div v-if="curso.estado === 0">
                                    <v-alert min-width="100" color="warning">Por realizarse</v-alert>
                                </div>
                                <div v-else-if="curso.estado === 1">
                                    <v-alert min-width="100" color="success">En curso</v-alert>
                                </div>
                                <div v-else>
                                    <v-alert min-width="150" color="error">Finalizado</v-alert>
                                </div>
                            </td>
                            <td class="">
                                <div v-if="curso.docente_inscrito.length > 0">
                                    <div v-for="inscrito in curso.docente_inscrito">
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
                                            store.get_curso_docente()
                                        }
                                    })">Inscribirse</primary-button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
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
