<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import Inscripcion from "../../dialogs/Inscripcion.vue";
import {ref} from 'vue';
import {Curso} from "@/store/curso.js";
import DangerButton from "@/Components/DangerButton.vue";
import EliminarDeteccionConfirmation from "@/Pages/Views/dialogs/EliminarDeteccionConfirmation.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import ActaCalificaciones from "@/Pages/Views/dialogs/ActaCalificaciones.vue";
import axios from 'axios'

const store = Curso();

const props = defineProps({
    curso: Object,
    auth: Object,
    docente: Array,
});
const timeout = ref(2000);

const dialog_inscripcion = ref(false);
const dialog = ref(false);
const dialogCalificacion = ref(false);
const snackbar = ref(false);
const loading = ref(false);
const loadingActa = ref(false);
const loadingConstancia = ref(false);
const snackbarInscritos = ref(false);
const snackbarError = ref(false);
const snackbarBien = ref(false);
const calificacion = ref(false);
const dialog_generar_acta = ref(false);
const dialog_constancia_pdf = ref(false);

const calificacion_string = ref("")
const formCalificacion = useForm({
    calificacion: calificacion_string.value,
    docente_id: null,
    curso_id: props.curso.id
})

const fila_seleccionada = (id) => {
    calificacion_string.value = ""
    formCalificacion.docente_id = id
    dialogCalificacion.value = true
}
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
    }).catch(error => {
        console.log(error.response.data)
        snackbar.value = true
    })
}
const submitCalificacion = () => {
    loading.value = true;
        formCalificacion.post(route('add.calificacion.desarrollo'), {
            onSuccess: () => {
                loading.value = false
                formCalificacion.reset();
                snackbarBien.value = true
                dialog_generar_acta.value = false
            },
            onError: () => {
                loading.value = false
                snackbarError.value = true
            },
        })
}

const submitActa = () => {
    loadingActa.value = true
    dialog_generar_acta.value = true
    axios.get(route('pdf.acta.calificaciones'), {
        params: {
            id: props.curso.id
        }
    }).then(res => {
        const url = '/storage/acta_de_calificaciones.pdf';
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'acta calificaciones.pdf');
        document.body.appendChild(link);
        link.click();
        loadingActa.value = false
        dialog_generar_acta.value = false
    }).catch(error => {
        console.log(error)
    })
}
const submitConstancia = (docente_id) => {
    loadingConstancia.value = true
    dialog_constancia_pdf.value = true
    axios.get(route('pdf.constancia'), {
        params: {
            id: props.curso.id,
            id_docente: docente_id
        }
    }).then(res => {
        const url = '/storage/constancia.pdf';
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'constancia.pdf');
        document.body.appendChild(link);
        link.click();
        loadingConstancia.value = false
        dialog_constancia_pdf.value = false
    }).catch(error => {
        loadingConstancia.value = false
        snackbarError.value = true
    })
}

const updateCalificacion = (calificacion, id) => {
    calificacion_string.value = calificacion
    formCalificacion.docente_id = id
    dialogCalificacion.value = true
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
    console.log(store.inscritos_calificacion)
    window.Echo.private('inscritos-chanel').listen('InscripcionEvent', (event) => {
        store.update_inscritos_desarrollo(event.inscritos)
        snackbarInscritos.value = true
    })
    window.Echo.private('calificacion-update').listen('CalificacionEvent', (event) => {
        store.update_calificacion_desarrollo(event.calificacion[0])
        calificacion.value = true
    })
    store.inscritos_curso_desarrollo(props.curso.id)
});


watch(calificacion_string, async (newCalificacion, oldCalificacion) => {
    formCalificacion.calificacion = newCalificacion.toUpperCase()
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">{{curso.nombreCurso}}</h2>
            <div class="grid grid-cols-2">
                <div class="flex justify-end mr-3">
                    <NavLink :href="route('curso.editar', props.curso.id)" as="button">
                        <PrimaryButton class="mt-5">Editar</PrimaryButton>
                    </NavLink>
                </div>
                <div class="flex justify-start">
                    <DangerButton @click="dialog = true" class="mt-5">Eliminar curso</DangerButton>
                    <EliminarDeteccionConfirmation v-model="dialog" :curso="props.curso.id" @update:modelValue="dialog = $event"></EliminarDeteccionConfirmation>
                </div>
            </div>
        </template>
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900">Docentes inscritos a este curso</h2>
                <div class="flex justify-start mt-3 mb-5">
                    <div class="flex justify-end items-end mt-2">
                        <v-btn @click="dialog_inscripcion = true" block size="large" color="blue-darken-1">Inscribir</v-btn>
                    </div>
                    <Inscripcion :errors="$page.props.errors" :auth="props.auth.user" :curso="props.curso" :docente="props.docente" v-model="dialog_inscripcion"  @update:modelValue="dialog_inscripcion = $event"></Inscripcion>
                </div>
                <div class="flex justify-end mb-10">
                    <template v-if="store.my_inscritos_desarrollo.length !== 0">
                        <v-btn color="blue-darken-1" @click="submitActa" :disabled="!store.inscritos_calificacion">Descargar Acta de Calificaciones</v-btn>
                    </template>
                </div>
                <v-table fixed-header height="500px" hover>
                    <thead>
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellido Paterno</th>
                        <th class="text-center">Apellido Materno</th>
                        <th class="text-center">CÉDULA DE INSCRIPCIÓN</th>
                        <th class="text-center">CALIFICACIÓN</th>
                        <th class="text-center">Constancia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="inscrito in store.my_inscritos_desarrollo"
                        :key="inscrito.id"

                    >
                        <td class="text-center">{{inscrito.nombre}}</td>
                        <td class="text-center">{{inscrito.apellidoPat}}</td>
                        <td class="text-center">{{inscrito.apellidoMat}}</td>
                        <td>
                            <div class="flex justify-center items-center">
                                <v-btn prepend-icon="mdi-file-pdf-box" color="blue-darken-1" @click="submit(inscrito.id, props.curso.id)">
                                    GENERAR PDF
                                </v-btn>
                            </div>
                        </td>
                        <td class="text-center">
                            <template v-if="inscrito.calificacion === null">
                                <v-btn icon @click="fila_seleccionada(inscrito.id)">
                                    <v-icon>mdi-pencil-plus</v-icon>
                                </v-btn>
                            </template>
                            <template v-else-if="inscrito.calificacion === 'NO APROBADO'">
                                <v-chip
                                    class="ma-2"
                                    color="red"
                                    text-color="white"
                                    @click="updateCalificacion(inscrito.calificacion, inscrito.id)"
                                >
                                    {{inscrito.calificacion}}
                                </v-chip>
                            </template>
                            <template v-else-if="inscrito.calificacion === 'APROBADO'">
                                <v-chip
                                    class="ma-2"
                                    color="success"
                                    text-color="white"
                                    @click="updateCalificacion(inscrito.calificacion, inscrito.id)"
                                >
                                    {{inscrito.calificacion}}
                                </v-chip>
                            </template>
                        </td>
                        <td class="text-center">
                            <template v-if="inscrito.calificacion === 'APROBADO'">
                                <v-btn icon="mdi-file-pdf-box" color="success" @click="submitConstancia(inscrito.id)">

                                </v-btn>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </v-table>
                <v-dialog width="auto" v-model="dialog_generar_acta">
                    <v-fade-transition leave-absolute>
                        <v-progress-circular
                            v-if="loadingActa"
                            color="info"
                            :size="64"
                            :width="7"
                            indeterminate
                        ></v-progress-circular>
                    </v-fade-transition>
                </v-dialog>
            </div>
        </div>
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
                                <span>Del {{curso.fecha_I}} al {{curso.fecha_F}}</span>
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
        <v-dialog width="auto" v-model="dialogCalificacion" persistent>
            <v-card width="500" height="500">
                <v-card-title>Añadir calificación</v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12">
                            <InputLabel for="calificacion"
                                        value="Unicamente ESCRIBIR si el docente esta APROBADO o NO APROBADO (MARCAR EN MAYÚSCULAS)" />
                        </v-col>
                        <v-col cols="10" class="mt-16">
                            <v-text-field variant="solo-filled" v-model="calificacion_string"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-dialog width="auto" v-model="loading">
                    <v-fade-transition leave-absolute>
                        <v-progress-circular
                            v-if="loading"
                            color="info"
                            :size="64"
                            :width="7"
                            indeterminate
                        ></v-progress-circular>


                    </v-fade-transition>
                </v-dialog>
                <v-card-actions>
                    <v-row justify="center">
                        <v-col cols="6" align="end" class="mr-16">
                            <danger-button @click="dialogCalificacion = false">
                                Cerrar
                            </danger-button>
                        </v-col>
                        <v-col cols="2" align="end" class="mr-16">
                            <primary-button elevation="5" color="success" @click="submitCalificacion">
                                Subir
                            </primary-button>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="auto" v-model="dialog_constancia_pdf">
            <v-fade-transition leave-absolute>
                <v-progress-circular
                    v-if="loadingConstancia"
                    color="info"
                    :size="64"
                    :width="7"
                    indeterminate
                ></v-progress-circular>
            </v-fade-transition>
        </v-dialog>
        <v-snackbar
            v-model="snackbar"
            vertical
            color="error"
            :timeout="timeout"
        >
            <div class="text-subtitle-1 pb-2">Error</div>

            <p>No se pudo generar correctamente la cédula de inscripción</p>

            <template v-slot:actions>
                <v-btn

                    @click="snackbar = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
        <v-snackbar
            v-model="snackbarInscritos"
            vertical
            color="info"
            :timeout="5000"
        >
            <div class="text-subtitle-1 pb-2"></div>

            <p>Se inscribio un nuevo docente a este curso</p>

            <template v-slot:actions>
                <v-btn

                    @click="snackbarInscritos = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
        <v-snackbar
            v-model="snackbarError"
            vertical
            color="error"
            :timeout="10000"
        >
            <div class="text-subtitle-1 pb-2"></div>

            <p>Se produjo un error</p>

            <template v-slot:actions>
                <v-btn

                    @click="snackbarError = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
        <v-snackbar
            v-model="snackbarBien"
            vertical
            color="success"
            :timeout="10000"
        >
            <div class="text-subtitle-1 pb-2"></div>

            <p>Se añadio la calificacion con exito</p>

            <template v-slot:actions>
                <v-btn

                    @click="snackbarBien = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
        <v-snackbar
            v-model="calificacion"
            vertical
            color="success"
            :timeout="10000"
        >
            <div class="text-subtitle-1 pb-2"></div>

            <p>Se añadio una calificacion</p>

            <template v-slot:actions>
                <v-btn

                    @click="calificacion = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
