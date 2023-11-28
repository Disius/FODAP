<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted} from "vue";
import {ref} from 'vue';
import NavLink from "@/Components/NavLink.vue";
import {FODAPStore} from "@/store/server.js";
import {Curso} from "@/store/curso.js";
import InputLabel from "@/Components/InputLabel.vue";
import {router, useForm} from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const my_curso_store = Curso()
const store = FODAPStore()

const props = defineProps({
    curso: Object,
    auth: Object,
    facilitador: Object,
    ficha_tecnica: Object,
    inscritos: Array,
});
const timeout = ref();
const id_teacher = ref(null);
const snackbar = ref(false);
const dialog = ref(false);
const loading = ref(false);
const message = ref("")
const color = ref("")


const formatFechaF = computed(() => {
    return new Date(props.curso.fecha_F).toLocaleDateString('es-MX');
})
const formatFechaI = computed(() => {
    return new Date(props.curso.fecha_I).toLocaleDateString('es-MX');
});
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
        snackSuccessActivator()
    }).catch(error => {
        snackErrorActivator()
    })
}

const generar_ficha = () => {
    axios.get(route('pdf.ficha.tecnica'), {
        params: {
            id_ficha: props.ficha_tecnica.id
        }
    }).then(res => {
        const url = '/storage/ficha.pdf';
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'ficha.pdf');
        document.body.appendChild(link);
        link.click();
        snackSuccessActivator()
    }).catch(error => {
        snackErrorActivator()
    })
};

const form = useForm({
    calificacion: null,
    docente_id: null,
    curso_id: props.curso.id
})
const fila_seleccionada = (id) => {
    form.docente_id = id
    dialog.value = true
}

const submitCalificacion = () => {
    loading.value = true;
    form.post(route('calificaciones.post'), {
        onSuccess: () => {
            loading.value = false
            form.reset();
            snackSuccessActivator()
        },
        onError: () => {
            loading.value = false
            snackErrorActivator()
        },
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
    });

    window.Echo.private('inscritos-chanel').listen('InscripcionEvent', (event) => {
        // my_curso_store.update_inscritos(event.inscritos)
        snackEventActivator()
    })
    window.Echo.private('calificacion-update').listen('CalificacionEvent', (event) => {
        // my_curso_store.update_calificacion(event.calificacion[0])
        snackEventActivator()
    })
    my_curso_store.inscritos_curso(props.curso.id)

});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">{{curso.nombreCurso}}</h2>
            <NavLink :href="route('show.facilitadores', props.facilitador.id)" as="button">
                <v-btn icon="mdi-arrow-left">

                </v-btn>
            </NavLink>
        </template>
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <v-table fixed-header height="500px" hover>
                    <thead>
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellido Paterno</th>
                        <th class="text-center">Apellido Materno</th>
                        <th class="text-center">CALIFICACIÓN</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="inscrito in props.inscritos"
                        :key="inscrito.id" :class="{ id_teacher: inscrito.id === id_teacher }"

                    >
                        <td class="text-center">{{inscrito.nombre}}</td>
                        <td class="text-center">{{inscrito.apellidoPat}}</td>
                        <td class="text-center">{{inscrito.apellidoMat}}</td>
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
                                >
                                    NO APROBADO
                                </v-chip>
                            </template>
                            <template v-else-if="inscrito.calificacion === 1">
                                <v-chip
                                    class="ma-2"
                                    color="success"
                                    text-color="white"
                                >
                                    APROBADO
                                </v-chip>
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
                    <v-card elevation="0">
                        <v-card-title class="text-center">Ficha Técnica</v-card-title>
                        <v-row justify="center">
                            <v-col cols="6" align="center">
                                <NavLink :href="route('crear.ficha', [props.facilitador.id, props.curso.id])">
                                    <v-btn color="blue-darken-1">
                                        Crear ficha técnica
                                    </v-btn>
                                </NavLink>
                            </v-col>
                            <v-col cols="6" align="center" class="mt-2">
                                <template v-if="props.ficha_tecnica === null">
                                    <v-btn color="blue-darken-1" prepend-icon="mdi-file-pdf-box" @click="snackErrorActivator">
                                        Descargar PDF
                                    </v-btn>
                                </template>
                                <template v-else>
                                    <v-btn color="blue-darken-1" prepend-icon="mdi-file-pdf-box" @click="generar_ficha">
                                        Descargar PDF
                                    </v-btn>
                                </template>
                            </v-col>
                        </v-row>
                    </v-card>
            </div>
        </div>
        <v-dialog width="auto" v-model="dialog" persistent>
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
                                v-model="form.calificacion"
                                column
                            >
                                <v-chip color="error">NO APROBADO</v-chip>

                                <v-chip color="success">APROBADO</v-chip>
                            </v-chip-group>
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
                            <danger-button @click="dialog = false">
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
        <CustomSnackBar :message="message" :timeout="timeout" :color="color" v-model="snackbar" @update:modelValue="snackbar = $event">

        </CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
