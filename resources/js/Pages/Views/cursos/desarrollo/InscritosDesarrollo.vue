<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import Inscripcion from "../../dialogs/Inscripcion.vue";
import {ref} from 'vue';

const props = defineProps({
    curso: Object,
    auth: Object,
    docente: Array,
});

const formatFechaF = computed(() => {
    return new Date(props.curso.fecha_F).toLocaleDateString('es-MX');
})
// Computed propierties


const formatFechaI = computed(() => {
    return new Date(props.curso.fecha_I).toLocaleDateString('es-MX');
});

const dialog_inscripcion = ref(false);
const snackbar = ref(false);

const submit = (inscripcion, id) => {
    axios.get(route('cdi.pdf'), {
        params: {
            docente: inscripcion,
            id_curso: id
        }
    }).then(res => {
        const url = '/storage/CDI.pdf';
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'CDI.pdf');
        document.body.appendChild(link);
        link.click();
        console.log(res.data)
    }).catch(error => {
        console.log(error.response.data)
        snackbar.value = true
    })
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
    })
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">{{curso.nombreCurso}}</h2>
            <NavLink href="">
                <NavLink :href="route('curso.editar', props.curso.id)" as="button">
                    <PrimaryButton class="mt-5">Editar</PrimaryButton>
                </NavLink>
            </NavLink>
        </template>
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center">
                    <div>
                        <div class="p-5">
                            <div class="flow-root ...">
                                <strong>Asignaturas en la que se requiere formación o actualización: </strong>
                                <v-divider></v-divider>
                                <span>{{props.curso.asignaturaFA}}</span>
                            </div>
                            <div class="flow-root ... pt-7">
                                <strong>Contenidos temáticos en que se requiere la formación o actualización: </strong>
                                <v-divider></v-divider>
                                <span>{{props.curso.contenidosTM}}</span>
                            </div>
                            <div class="flow-root ... pt-7">
                                <strong>Número de profesores(as) que la requieren: </strong>
                                <span>{{props.curso.numeroProfesores}}</span>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Modalidad: </strong>
                                <template v-if="props.curso.modalidad === 1">
                                    <span>Virtual</span>
                                </template>
                                <template v-if="props.curso.modalidad === 2">
                                    <span>Presencial</span>
                                </template>
                                <template v-if="props.curso.modalidad === 3">
                                    <span>Hibrído</span>
                                </template>

                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Periodo en el que se requiere la formación o actualización (enero-junio o agosto diciembre): </strong>
                                <template v-if="props.curso.periodo === 1">
                                    <span>ENERO-JUNIO</span>
                                </template>
                                <template v-if="props.curso.periodo === 2  ">
                                    <span>AGOSTO-DICIEMBRE</span>
                                </template>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Carrera a la que va dirigido: </strong>
                                <span>{{props.curso.carrera.nameCarrera}}</span>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Facilitador(es): </strong>
                                <div v-for="facilitador in props.curso.deteccion_facilitador">
                                    <span>{{facilitador.nombre}}  {{facilitador.apellidoPat}}  {{facilitador.apellidoMat}}</span>
                                </div>
                            </div>
                            <template v-if="props.curso.facilitador_externo != null">
                                <div class="flow-root ... pt-5">
                                    <strong>Facilitador externo: </strong>
                                    <span>{{props.curso.facilitador_externo}}</span>
                                </div>
                            </template>
                            <div class="flow-root ... pt-5">
                                <strong>Tipo de curso, taller, conferencias, etc: </strong>
                                <template v-if="props.curso.tipo_actividad === 1">
                                    <span>TALLER</span>
                                </template>
                                <template v-if="props.curso.tipo_actividad === 2">
                                    <span>CURSO</span>
                                </template>
                                <template v-if="props.curso.tipo_actividad === 3">
                                    <span>CURSO-TALLER</span>
                                </template>
                                <template v-if="props.curso.tipo_actividad === 4">
                                    <span>FORO</span>
                                </template>
                                <template v-if="props.curso.tipo_actividad === 5">
                                    <span>SEMINARIO</span>
                                </template>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Tipo de solicitud: </strong>
                                <template v-if="props.curso.tipo_FDoAP === 1">
                                    <span>FORMACIÓN DOCENTE</span>
                                </template>
                                <template v-if="props.curso.tipo_FDoAP === 2">
                                    <span>ACTUALIZACIÓN PROFESIONAL</span>
                                </template>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Fechas en las que se realizara la actividad o evento: </strong>
                                <span>Del {{formatFechaI}} al {{formatFechaF}}</span>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Horarios en las que se realizara la actividad o evento: </strong>
                                <span>De {{props.curso.hora_I}} a {{props.curso.hora_F}}</span>
                            </div>
                            <div class="flow-root ... pt-5">
                                <strong>Objetivo de la actividad o evento: </strong>
                                <v-divider></v-divider>
                                <span>{{props.curso.objetivoEvento}}</span>
                            </div>
                            <template v-if="props.curso.obs === 1">
                                <div class="flow-root ... pt-5">
                                    <strong>Observaciones: </strong>
                                    <v-divider></v-divider>
                                    <span>{{props.curso.observaciones}}</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900">Docentes inscritos a este curso</h2>
                <div class="flex justify-end items-end mt-2">
                    <v-btn @click="dialog_inscripcion = true" block size="large" color="blue-darken-1">Inscribir Docentes a Este Curso</v-btn>
                </div>
                <Inscripcion :curso="props.curso" :docente="props.docente" v-model="dialog_inscripcion"  @update:modelValue="dialog_inscripcion = $event"></Inscripcion>
            </div>
        </div>
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <v-table fixed-header height="500px" hover>
                    <thead>
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellido Paterno</th>
                        <th class="text-center">Apellido Materno</th>
                        <td class="text-center">CÉDULA DE INSCRIPCIÓN</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="inscrito in props.curso.docente_inscrito"
                        :key="inscrito.id"

                    >
                        <td class="text-center">{{inscrito.nombre}}</td>
                        <td class="text-center">{{inscrito.apellidoPat}}</td>
                        <td class="text-center">{{inscrito.apellidoMat}}</td>
                        <td>
                            <div class="flex justify-center items-center">
                                <v-btn prepend-icon="mdi-file-pdf-box" color="blue-darken-1" @click="submit(inscrito, props.curso.id)">
                                    GENERAR PDF
                                </v-btn>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </v-table>
            </div>
        </div>

        <v-snackbar
            v-model="snackbar"
            vertical
            color="error"
        >
            <div class="text-subtitle-1 pb-2">Error</div>

            <p>No se pudo generar correctamente la cédula de inscripción</p>

            <template v-slot:actions>
                <v-btn

                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
