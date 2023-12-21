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
import {router, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import axios from 'axios'
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import Loading from "@/Components/Loading.vue";

const store = Curso();

const props = defineProps({
    curso: Object,
    auth: Object,
    docente: Array,
    inscritos: Array,
});
const timeout = ref(0);

const dialog_inscripcion = ref(false);
const dialog = ref(false);
const dialogCalificacion = ref(false);
const snackbar = ref(false);
const loading = ref(false);
const calificacion = ref(false);
const color = ref("")
const message = ref("")


const formCalificacion = useForm({
    calificacion: null,
    docente_id: null,
    curso_id: props.curso.id
})
const reloadPage = () => {
    router.reload();
    snackbar.value = false
}
const fila_seleccionada = (docente_id) => {
    formCalificacion.docente_id = docente_id
    dialogCalificacion.value = true
}

const if_calificacion = computed(() => {
    return props.inscritos.every(inscrito => inscrito.calificacion !== null)
})
const submit = (inscripcion, id) => {
    loading.value = true
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
        snackSuccessActivator()
        loading.value = false
    }).catch(error => {
        snackErrorActivator()
        loading.value = false
    })
}
const submitCalificacion = () => {
    loading.value = true;
        formCalificacion.post(route('add.calificacion.desarrollo'), {
            onSuccess: () => {
                loading.value = false
                formCalificacion.reset();
                snackSuccessActivator()
            },
            onError: () => {
                loading.value = false
                snackErrorActivator()
            },
        })
}

const submitActa = () => {
    loading.value = true
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
        loading.value = false
        snackSuccessActivator()
    }).catch(error => {
        loading.value = false
        snackErrorActivator()
    })
}
const submitConstancia = (docente_id) => {
    loading.value = true
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
        loading.value = false
        snackSuccessActivator()
    }).catch(error => {
        loading.value = false
        snackErrorActivator()
    })
}

const updateCalificacion = (calificacion, id) => {
    formCalificacion.calificacion = calificacion
    formCalificacion.docente_id = id
    dialogCalificacion.value = true
}

const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 8000
    setTimeout(()=>{
        snackbar.value = false
    },timeout.value)
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(()=>{
        snackbar.value = false
    },timeout.value)
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(()=>{
        snackbar.value = false
    },timeout.value)
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
    window.Echo.private('inscritos-chanel').listen('InscripcionEvent', (event) => {
        snackEventActivator()
    })
    window.Echo.private('calificacion-update').listen('CalificacionEvent', (event) => {
        snackEventActivator()
    })
    store.inscritos_curso_desarrollo(props.curso.id)
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-3">
                <div class="flex justify-center">
                    <h2 class="text-h5 font-medium text-gray-900">{{props.curso.nombreCurso}}</h2>
                </div>
                <template v-if="props.curso.clave_curso !== null">
                    <div class="flex justify-center">
                        <h2 class="font-medium text-gray-900">Clave del curso: {{props.curso.clave_curso.clave}}</h2>
                    </div>
                </template>
                <template v-if="props.curso.clave_validacion !== null">
                    <div class="flex justify-center">
                        <h2 class="font-medium text-gray-900">Clave de validación: {{props.curso.clave_validacion.clave}}</h2>
                    </div>
                </template>
            </div>
            <div class="grid grid-cols-3">
                <template v-if="props.curso.estado === 0 || props.curso.estado === 1">
                    <div class="flex justify-start">
                        <NavLink :href="route('index.desarrollo.cursos')" as="button" type="button">
                            <v-btn icon color="blue-darken-1">
                                <v-icon>mdi-arrow-left</v-icon>
                            </v-btn>
                        </NavLink>
                    </div>
                </template>
                <template v-if="props.curso.estado === 2">
                    <div class="flex justify-start">
                        <NavLink :href="route('index.registros.c')" as="button" type="button">
                            <v-btn icon color="blue-darken-1">
                                <v-icon>mdi-arrow-left</v-icon>
                            </v-btn>
                        </NavLink>
                    </div>
                </template>
                <div class="flex justify-end mr-3">
                    <NavLink :href="route('curso.editar', props.curso.id)" as="button">
                        <v-btn color="blue-darken-1" class="mt-5">Editar</v-btn>
                    </NavLink>
                </div>
                <div class="flex justify-start mr-16 pr-16">
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
                    <template v-if="props.inscritos.length !== 0">
                        <v-btn color="blue-darken-1" @click="submitActa" :disabled="!if_calificacion">Descargar Acta de Calificaciones</v-btn>
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
                        v-for="inscrito in props.inscritos"
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
                            <template v-else-if="inscrito.calificacion === 0">
                                <v-chip
                                    class="ma-2"
                                    color="red"
                                    text-color="white"
                                    @click="updateCalificacion(inscrito.calificacion, inscrito.id)"
                                >
                                    <p class="text-center">NO APROBADO</p>
                                </v-chip>
                            </template>
                            <template v-else-if="inscrito.calificacion === 1">
                                <v-chip
                                    class="ma-2"
                                    color="success"
                                    text-color="white"
                                    @click="updateCalificacion(inscrito.calificacion, inscrito.id)"
                                >
                                    <p class="text-center">APROBADO</p>
                                </v-chip>
                            </template>
                        </td>
                        <td class="text-center">
                            <template v-if="inscrito.calificacion === 1">
                                <v-btn icon="mdi-file-pdf-box" color="success" @click="submitConstancia(inscrito.id)">

                                </v-btn>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </v-table>
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
                                <span>Del {{props.curso.fecha_I}} al {{props.curso.fecha_F}}</span>
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
            <v-card width="500" height="300">
                <v-card-title>Añadir calificación</v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12">
                            <InputLabel for="calificacion"
                                        value="Unicamente SELECCIONAR si el docente esta APROBADO o NO APROBADO" />
                        </v-col>
                        <v-col cols="8" class="mt-5 ml-6" align="center">
                            <v-chip-group
                            v-model="formCalificacion.calificacion"
                            column
                            >
                                <v-chip color="error">NO APROBADO</v-chip>

                                <v-chip color="success">APROBADO</v-chip>
                            </v-chip-group>
                        </v-col>
                    </v-row>
                </v-card-text>
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

        <CustomSnackBar :message="message" :color="color" v-model="snackbar" @update:modelValue="snackbar = $event" :timeout="timeout">
            <template v-slot:reloadingbutton>
                <div class="flex justify-start pa-1">
                    <v-btn @click="reloadPage" icon="mdi-reload"></v-btn>
                </div>
            </template>
        </CustomSnackBar>
        <Loading v-model="loading" @update:loading="loading = $event">
            <v-fade-transition leave-absolute>
                <v-progress-circular
                    v-if="loading"
                    color="info"
                    :size="64"
                    :width="7"
                    indeterminate
                ></v-progress-circular>
            </v-fade-transition>
        </Loading>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
