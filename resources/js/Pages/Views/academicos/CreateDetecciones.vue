<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeteccionesForm from "@/Pages/Views/academicos/forms/DeteccionesForm.vue";
import {computed, onMounted, ref, watch} from "vue";
import NavLink from "@/Components/NavLink.vue";
import ResetForm from "@/Pages/Views/dialogs/ResetForm.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CreateDocenteA from "@/Pages/Views/academicos/docentes/CreateDocenteA.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const props = defineProps({
    base_docente: {
        type: Array,
    },
    carrera_filtro: {
        type: Array
    },
    todos_los_departamentos: {
        type: Array
    },
    auth: {
        type: Object
    },
    lugar: {
        type: Array
    },
    errors: {
        type: Object,
    },
    tipo_plaza: {
        type: Array,
    },
    puesto: {
        type: Array
    },
    carrera: {
        type: Array,
    },
    posgrado: {
        type: Array
    },
    departamento: {
        type: Array
    }
});

const emit = defineEmits([
    'update:modelValue'
]);
const user = computed(() => usePage().props.auth.user);
// let dialogReset = ref(false);
const snackbar = ref(false);
const timeout = ref(0)
const message = ref("");
const color = ref("")
const dialogDocente = ref(false)
const dialog = ref(true);
let horas_totales = ref();

const form = useForm({
    AsignaturasFA: "",
    ContenidoTFA: "",
    Numprofesores: null,
    periodo: null,
    facilitadores: [],
    nombreCT: "",
    fecha_I: "",
    fecha_F: "",
    hora_I: "",
    hora_F: "",
    objetivo: "",
    tipo: null,
    tipo_act: null,
    dirigido: null,
    modalidad: null,
    facilitador_externo: null,
    id_jefe: user.value.docente_id,
    observaciones: null,
});

const tipoSolicitud = ref([
    { text: "FORMACIÓN DOCENTE", value: 1 },
    { text: "ACTUALIZACIÓN PROFESIONAL", value: 2 }
]);
const modalidad = [
    { text: "Virtual", value: 1 },
    { text: "Presencial", value: 2 },
    { text: "Híbrido", value: 3 },
];
const tipoCurso = ref([
    { value: 1, text: "TALLER" },
    { value: 2, text: "CURSO" },
    { value: 3, text: "CURSO-TALLER" },
    { value: 4, text: "FORO" },
    { value: 5, text: "SEMINARIO" },
    {value:6, text:"DIPLOMADO"}
]);
const period = ref([
    {text: "enero-junio", value: 1},
    {text: "agosto-diciembre", value: 2},
]);
const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 8000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const carreraFilter = computed(() => {
    let filtro = props.carrera_filtro
    const addTodas = { nameCarrera: "TODAS LAS CARRERAS", id: 13 }

    filtro.push(addTodas);

    return filtro;
});

const lugarSinOcupar = computed(() => {
    return props.lugar.filter(e => {
        return e.curso === null
    })
});
const maxCount = [
    value => {
        if (value.length <= 3) return true

        return "Deben ser maximo tres facilitadores";
    }
]

function totalHoras(fechaInicio, fechaFinal, horaInicio, horaFinal) {
    let fechaInicioParts = fechaInicio.split('-');
    let fechaFinalParts = fechaFinal.split('-');
    let fechaInicioObj = new Date(fechaInicioParts[0], fechaInicioParts[1] - 1, fechaInicioParts[2]);
    let fechaFinalObj = new Date(fechaFinalParts[0], fechaFinalParts[1] - 1, fechaFinalParts[2]);
    let horaInicioObj = new Date(`01/01/1970 ${horaInicio}`).toLocaleTimeString('es-MX', { timeZone: 'America/Mexico_City' });
    let horaFinalObj = new Date(`01/01/1970 ${horaFinal}`).toLocaleTimeString('es-MX', { timeZone: 'America/Mexico_City' });

    let diasHabiles = 0;
    let horasTotales = 0;
    // console.log(fechaFinalObj, fechaFinal)
    function esDiaDeSemana(fecha) {
        const dia = fecha.getDay();
        return dia !== 0 && dia !== 6; // 0 representa domingo, 6 representa sábado
    }

    while (fechaInicioObj <= fechaFinalObj) {
        if (esDiaDeSemana(fechaInicioObj)) {
            diasHabiles++;
            // Calcular las horas entre la hora de inicio y la hora final en zona horaria de México
            let tiempoInicio = new Date(`${fechaInicioObj.toISOString().slice(0, 10)} ${horaInicioObj}`).getTime();
            let tiempoFinal = new Date(`${fechaInicioObj.toISOString().slice(0, 10)} ${horaFinalObj}`).getTime();

            let tiempoTranscurrido = tiempoFinal - tiempoInicio;
            let horaEnDia = tiempoTranscurrido / (1000 * 60 * 60); // Convertir a horas
            horasTotales += horaEnDia;
        }
        fechaInicioObj.setDate(fechaInicioObj.getDate() + 1); // Avanzar al siguiente día
    }

    return horasTotales;
}

async function submitDocente(form){
    try {
        form.post(route('create.docentes.academicos.up'), {
            onSuccess: () => {
                dialogDocente.value = false
                snackSuccessActivator()
                form.reset()
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    }catch (e) {
        snackErrorActivator()
    }
}

watch(() => [form.fecha_I, form.fecha_F, form.hora_I, form.hora_F], ([newFechaI, newFechaF, newHoraI, newHoraF], [oldFechaI, oldFechaF, oldHoraI, oldHoraF]) => {
    // console.log(newFechaI, newFechaF, newHoraI, newHoraF)
    if (newFechaI && newFechaF && newHoraI && newHoraF){
        horas_totales.value = totalHoras(newFechaI, newFechaF, newHoraI, newHoraF)
        // totalHoras(newFechaI, newFechaF, newHoraI, newHoraF)
    }
})


const submit = () => {
    form.post(route('store.detecciones'), {
        onSuccess: () => {
            form.reset();
            dialogReset.value = true;
            dialog.value = true;
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        },
    })
}
const dialogReset = ref(false);
// const dialog = ref(true);
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
            <NavLink :href="route('detecciones.index')" as="button" type="button">
                <v-btn icon color="blue-darken-1">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
            </NavLink>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-4">Nueva Deteccion de Necesidades</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <v-dialog v-model="dialog" width="500" persistent>
                            <v-card width="500">
                                <v-card-title class="text-center">Tipo de diagnostico que desea realizar</v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-container class="mt-6">
                                        <InputLabel for="tipo_solicitud" value="Tipo de solicitud" />
                                        <v-row align="center" justify="center" class="mt-2">
                                            <v-select variant="solo" :items="tipoSolicitud" item-title="text" item-value="value"
                                                      v-model="form.tipo">

                                            </v-select>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <div class="flex items-center mr-5 mb-7 justify-end gap-4">
                                    <NavLink :href="route('detecciones.index')" as="button" type="button">
                                        <v-btn color="error">
                                            Cancelar
                                        </v-btn>
                                    </NavLink>
                                    <PrimaryButton @click="dialog = false" :disabled="form.processing">Confirmar</PrimaryButton>

                                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Confirmado.</p>
                                    </Transition>
                                </div>
                            </v-card>
                        </v-dialog>

                        <v-row justify="center">
                            <template v-if="form.tipo != null">
                                <v-container class="mt-5">
                                    <v-row justify="center">
                                        <template v-if="form.tipo === 1">
                                            <v-col cols="12" align-="center">
                                                <v-row justify="center">
                                                    <v-col align="start" cols="5">
                                                        <InputLabel for="asignaturas"
                                                                    value="Dimensión(es) en la(s) que se requiere Formación Docente" />
                                                    </v-col>
                                                    <v-col align="end" cols="7" class="mb-0 pa-0">
                                                        <div class="d-flex justify-start mb-5">
                                                            <v-tooltip location="right">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon color="blue-darken-1" v-bind="props" size="normal">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar la dimensión, resultado de la evaluación docente, en la que
                                                        se requiere formación docente.</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                                <v-text-field required v-model="form.AsignaturasFA" variant="solo">

                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-row justify="center">
                                                    <v-col align="start" cols="5">
                                                        <InputLabel for="contenido"
                                                                    value="Competencia(s) en la(s) que se requiere la Formación Docente" />
                                                    </v-col>
                                                    <v-col align="start" cols="7" class="mb-0 pa-0">
                                                        <div class="d-flex justify-start mb-5">
                                                            <v-tooltip location="right">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar las competencias en que requiere la formación
                                                        docente</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                                <v-textarea required v-model="form.ContenidoTFA" variant="solo">

                                                </v-textarea>
                                            </v-col>
                                        </template>
                                        <template v-if="form.tipo === 2">
                                            <v-col cols="12" align-self="center">
                                                <v-row justify="center">
                                                    <v-col align="start" cols="5">
                                                        <InputLabel for="asignaturas"
                                                                    value="Asignatura(s) en la(s) que se requiere Actualización profesional" />
                                                    </v-col>
                                                    <v-col align="start" cols="7" class="mb-0 pa-0">
                                                        <div class="d-flex justify-start mb-5">
                                                            <v-tooltip location="right">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar el nombre de la(s) asignatura(s) en la(s) que se requiere
                                                        Actualización Profesional.</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                                <v-text-field required v-model="form.AsignaturasFA" variant="solo">

                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-row justify="center">
                                                    <v-col align="start" cols="10">
                                                        <InputLabel for="contenidosTM"
                                                                    value="Contenidos temáticos en que se requiere Actualización Profesional" />
                                                    </v-col>
                                                    <v-col align="start" cols="2" class="mb-0 pa-0">
                                                        <div class="d-flex justify-start mb-5">
                                                            <v-tooltip location="right">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar los contenidos temáticos de la asignatura que requiere la
                                                        Actualización Profesional.</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                                <v-textarea required v-model="form.ContenidoTFA" variant="solo">

                                                </v-textarea>
                                            </v-col>
                                        </template>
                                    </v-row>
                                    <v-row justify="center">
                                        <v-col cols="12" class="mt-1">
                                            <v-row justify="center">
                                                <v-col align="start" cols="10" class="">
                                                    <template v-if="form.tipo === 1">
                                                        <InputLabel for="numProfesores"
                                                                    value="Número de profesores(as) que requieren Formación Docente" />
                                                    </template>
                                                    <template v-else>
                                                        <InputLabel for="numProfesores"
                                                                    value="Número de profesores(as) que requieren Actualización Profesional." />
                                                    </template>
                                                </v-col>
                                                <v-col align="start" cols="2" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Indicar el número de profesores(as) que requieren Formación Docente o
                                                    Actualización Profesional.</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-text-field required v-model="form.Numprofesores" variant="solo">

                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="">
                                            <v-row justify="center">
                                                <v-col align="start" cols="11">
                                                    <template v-if="form.tipo === 1">
                                                        <InputLabel for="periodo"
                                                                    value="Periodo en el que se requiere la Formación Docente (enero-junio o agosto-diciembre)" />
                                                    </template>
                                                    <template v-else>
                                                        <InputLabel for="periodo"
                                                                    value="Periodo en el que se requiere la Actualización Profesional (enero-junio o agosto-diciembre)" />
                                                    </template>
                                                </v-col>
                                                <v-col align="start" cols="1" class="mb-4">
                                                    <div class="d-flex justify-start ">
                                                        <v-tooltip location="left">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Indicar el periodo en el que se requiere la formación docente o
                                                    actualización profesiona (enero-junio o agosto-diciembre)</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-select required v-model="form.periodo" :items="period" item-title="text"
                                                      item-value="value" variant="solo">

                                            </v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-row justify="center">
                                                <v-col align="start" cols="3">
                                                    <InputLabel for="modalidad" value="Modalidad" />
                                                </v-col>
                                                <v-col align="start" cols="9" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>La modalidad en la que se realizara el curso.</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-select variant="solo" required :items="modalidad" item-title="text" item-value="value"
                                                      v-model="form.modalidad">

                                            </v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-row justify="center">
                                                <v-col align="start" cols="5">
                                                    <InputLabel for="tipo_curso" value="Tipo de curso" />
                                                </v-col>
                                                <v-col align="start" cols="7" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>El tipo de actividad a realizar.</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-select required :items="tipoCurso" item-title="text" item-value="value"
                                                      v-model="form.tipo_act" variant="solo">

                                            </v-select>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row justify="center">
                                                <v-col align="start" cols="5">
                                                    <InputLabel for="carrera" value="PARA LOS(AS) PROFESORES(AS) DE LA ACADEMIA DE" />
                                                </v-col>
                                                <v-col align="start" cols="7" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Seleccionar el nombre de la academia correspondiente.</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-select required :items="carreraFilter" item-title="nameCarrera" item-value="id"
                                                      v-model="form.dirigido" variant="solo">

                                            </v-select>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-col align="start" cols="4">
                                                <InputLabel for="facilitador"
                                                            value="Facilitador(a) que impartirá el curso/taller" />
                                            </v-col>
                                            <v-col align="start" cols="4" class="mb-0 pa-0">
                                                <div class="d-flex justify-start mb-5">
                                                    <v-tooltip location="right">
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar el nombre del facilitador (a) que impartirá el
                                                    curso/taller.</span>
                                                    </v-tooltip>
                                                </div>
                                            </v-col>
                                            <v-col cols="4">
                                                <primary-button @click="dialogDocente = true">Crear Docente</primary-button>

                                                <create-docente-a
                                                :auth="props.auth"
                                                :carrera="props.carrera"
                                                :departamento="props.departamento"
                                                :posgrado="props.posgrado"
                                                :puesto="props.puesto"
                                                :tipo_plaza="props.tipo_plaza"
                                                v-model="dialogDocente"
                                                @update:modelValue="dialogDocente = $event"
                                                @docente-add="submitDocente"
                                                >

                                                </create-docente-a>
                                            </v-col>
                                            <v-autocomplete :counter="3" multiple :items="props.base_docente" item-title="nombre_completo" item-value="id"
                                                            v-model="form.facilitadores" variant="solo" :rules="maxCount" class="mt-4">

                                            </v-autocomplete>
                                        </v-col>
                                        <v-col align-self="center">
                                            <v-row justify="center">
                                                <v-col align="start" cols="5">
                                                    <InputLabel for="facilitador_externo"
                                                                value="Facilitador(a) externo que impartirá el curso/taller" />
                                                </v-col>
                                                <v-col align="start" cols="7" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="top">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>En caso de que el facilitador sea externo. Poner el nombre completo de la empresa, en caso de ser una persona externa anotar el nombre completo</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-text-field v-model="form.facilitador_externo"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row justify="center">
                                                <v-col align="start" cols="5">
                                                    <InputLabel for="nombreCurso"
                                                                value="Nombre del curso, taller, conferencias, etc." />
                                                </v-col>
                                                <v-col align="start" cols="7" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <template v-if="form.tipo === 1">
                                                            <v-tooltip location="bottom">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar el nombre del curso, taller, conferencias, etc., que se
                                                        llevarán a cabo para la Formación Docente del (de la) profesor(a) en
                                                        las dimensiones de la Evaluación Docente.</span>
                                                            </v-tooltip>
                                                        </template>
                                                        <template v-else>
                                                            <v-tooltip location="bottom">
                                                                <template v-slot:activator="{ props }">
                                                                    <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                                                        <v-icon>
                                                                            mdi-help
                                                                        </v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <span>Anotar el nombre del curso, taller, conferencias, etc., que se
                                                        llevarán a cabo para la actualización profesional del (de la)
                                                        profesor(a) en la(s) asignatura(s) que se requiere</span>
                                                            </v-tooltip>
                                                        </template>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-text-field required v-model="form.nombreCT">

                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row justify="center">
                                                <v-col align="start" cols="8">
                                                    <h4>Elegir las fechas en que se
                                                        realizará la actividad
                                                        o evento</h4>
                                                </v-col>
                                                <v-col align="start" cols="4" class="mb-0 pa-0">
                                                    <div class="d-flex justify-start mb-5">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Seleccionar la fecha en que se realizará la actividad o evento</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-row justify="center">
                                                <v-col cols="6">
                                                    <v-text-field label="Inicio" required type="date" v-model="form.fecha_I" />
                                                </v-col>
                                                <v-col cols="6">
                                                    <v-text-field label="Termino" required type="date" v-model="form.fecha_F" />
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-row justify="center">
                                                <v-col align="start" cols="12">
                                                    <h4>Elegir los horarios en que
                                                        se realizará la
                                                        actividad o
                                                        evento</h4>
                                                    <div class="d-flex justify-start mb-0">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Indicar el horario en que se realizará la actividad o evento</span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-row justify="center">
                                                <v-col cols="6" align="center" class="">
                                                    <v-text-field label="Inicio" required type="time" v-model="form.hora_I" />
                                                </v-col>
                                                <v-col cols="6">
                                                    <!--                                        <InputLabel for="time" valuet="kd"/>-->
                                                    <v-text-field label="Termino" class="" required type="time" v-model="form.hora_F" />
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-row justify="center">
                                            <v-col cols="6" align="center" class="">
                                                <template v-if="horas_totales < 30">
                                                    <v-chip variant="flat" color="error" prepend-icon="mdi-cancel">
                                                        El curso es menor a 30 horas
                                                    </v-chip>
                                                </template>
                                                <template v-else-if="horas_totales >= 30">
                                                    <v-chip variant="flat" color="success" prepend-icon="mdi-check-circle">
                                                        El curso es de {{horas_totales}} horas
                                                    </v-chip>
                                                </template>
                                            </v-col>
                                        </v-row>
                                        <v-col align-self="center" cols="12">
                                            <v-row justify="center">
                                                <v-col align="start" cols="5">
                                                    <InputLabel for="objetivo" value="Objetivo de la actividad o evento" />
                                                </v-col>
                                                <v-col align="start" cols="7" class="mb-5 pa-0">
                                                    <div class="d-flex justify-end mb-0">
                                                        <v-tooltip location="right">
                                                            <template v-slot:activator="{ props }">
                                                                <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                                                    <v-icon>
                                                                        mdi-help
                                                                    </v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>Anotar el objetivo de la actividad o evento. </span>
                                                        </v-tooltip>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-text-field required v-model="form.objetivo">

                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <div class="flex justify-center mr-12 h-6 items-center gap-4">
                                    <PrimaryButton class="w-45 h-12" :disabled="form.processing">
                                        <span class="flex justify-center items-center">Guardar</span>
                                    </PrimaryButton>
                                    <!--                        <v-btn :disabled="form.processing" rounded="xl" prepend-icon="mdi-pen-plus" color="blue-darken-1" block size="large">-->
                                    <!--                            Crear-->
                                    <!--                        </v-btn>-->

                                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                                    </Transition>
                                </div>
                            </template>
                        </v-row>
                    </form>
                    <ResetForm v-model="dialogReset" @update:modelValue="dialogReset = $event"></ResetForm>
                </div>
            </div>
        </div>
        <custom-snack-bar
        :timeout="timeout" :color="color" :message="message" v-model="snackbar" @update:modelValue="snackbar = $event"
        >

        </custom-snack-bar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
