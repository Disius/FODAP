<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import {computed, onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import CreateDocenteA from "@/Pages/Views/academicos/docentes/CreateDocenteA.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
const props = defineProps({
    auth: {
        type: Object
    },
    carrera: {
        type: Array,
    },
    docentes: {
        type: Array
    },
    todos_los_departamentos: {
        type: Array,
    },
    lugar: {
        type: Array
    },
    curso: {
        type: Object
    },
    posgrado: {
        type: Array,
    },
    puesto: {
        type: Array
    },
    tipo_plaza: {
        type: Array,
    },
    errors: Object
});

const snackbar = ref(false)
const message = ref("")
const timeout = ref()
const color = ref("")
const dialogDocente = ref(false)

const tipoSolicitud = ref([
    {text: "FORMACIÓN DOCENTE", value:1},
    {text: "ACTUALIZACIÓN PROFESIONAL", value:2}
]);
const modalidad = [
    {text: "Virtual", value:1},
    {text: "Presencial", value:2},
    {text: "Híbrido", value:3},
];
const tipoCurso = ref([
    {value:1, text:"TALLER"},
    {value:2, text:"CURSO"},
    {value:3, text:"CURSO-TALLER"},
    {value:4, text:"FORO"},
    {value:5, text:"SEMINARIO"},
    {value:6, text:"DIPLOMADO"}
]);
const period = ref([
    {text: "enero-junio", value: 1},
    {text: "agosto-diciembre", value: 2},
]);

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
    id_lugar: null,
    observaciones: null,
    jefe: props.curso.jefe.id,
    departamento: props.curso.departamento.id,
});
const filtroCarrera = computed(() => {
    let filtro = props.carrera.filter(e => {
        return e.departamento_id === form.id_departamento
    });
    const addTodas = {nameCarrera: "TODAS LAS CARRERAS", id: 11};
    filtro.push(addTodas)
    return filtro;
});

const jefe_id = computed(() => {
    for(let d of props.todos_los_departamentos){
        d.id === form.id_departamento ? form.id_jefe = d.jefe_id : null
    }
});
const fullYears = computed(() => {
    const maxYears = new Date().getFullYear();
    const minYears = maxYears - 6;
    const years = [];

    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});

async function submitDocente(form){
    try {
        form.post(route('store.docentes'), {
            onSuccess: () => {
                message.value = "El recurso se actualizó con éxito."
                 color.value = "success"
                timeout.value = 5000
                snackbar.value = true
                setTimeout(() => {
                snackbar.value = false
                }, timeout.value)
                form.reset()
                dialogDocente.value = false
            },
            onError: () => {
                message.value = props.errors[0]
                 color.value = "error"
                timeout.value = 5000
                snackbar.value = true
                setTimeout(() => {
                    snackbar.value = false
                },  timeout.value)
            }
        })
    }catch (e) {
        snackErrorActivator()
    }
}
onMounted(() => {
    form.AsignaturasFA = props.curso.asignaturaFA
    form.ContenidoTFA = props.curso.contenidosTM
    form.Numprofesores = props.curso.numeroProfesores
    form.periodo = props.curso.periodo
    form.nombreCT = props.curso.nombreCurso
    form.fecha_I = props.curso.fecha_I
    form.fecha_F = props.curso.fecha_F
    form.hora_I = props.curso.hora_I
    form.hora_F =props.curso.hora_F
    form.tipo = props.curso.tipo_FDoAP
    form.tipo_act = props.curso.tipo_actividad
    form.dirigido = props.curso.carrera_dirigido
    form.id_departamento = props.curso.id_departamento
    form.objetivo = props.curso.objetivoEvento
    form.modalidad = props.curso.modalidad
    form.facilitador_externo = props.curso.facilitador_externo
    form.id_lugar = props.curso.id_lugar
    form.observaciones = props.curso.observaciones
    for (let i of props.curso.deteccion_facilitador){
        form.facilitadores.push(i.id);
    }
})

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-4">Editar Curso</h2>
            <div class="flex justify-start">
                <NavLink :href="route('index.desarrollo.inscritos', props.curso.id)" as="button" type="button">
                    <v-btn icon color="blue-darken-1">
                        <v-icon>mdi-arrow-left</v-icon>
                    </v-btn>
                </NavLink>
            </div>
        </template>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="form.put(route('update.curso', props.curso.id))">
                        <v-container>
                            <InputLabel for="tipo_solicitud" value="Tipo de solicitud" />
                            <v-row align="center" justify="center" class="mt-2">
                                <v-select :items="tipoSolicitud" item-title="text" item-value="value"
                                          v-model="form.tipo" variant="solo" required>

                                </v-select>
                            </v-row>
                            <v-row justify="center">
                                <template v-if="form.tipo === 1">
                                    <v-col cols="12" align-="center">
                                        <v-row justify="center">
                                            <v-col align="start" cols="5">
                                                <InputLabel for="asignaturas" value="Dimensión(es) en la(s) que se requiere Formación Docente"  />
                                            </v-col>
                                            <v-col align="end" cols="7" class="mb-0 pa-0">
                                                <div class="d-flex justify-start mb-5">
                                                    <v-tooltip
                                                        location="right"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                color="blue-darken-1"
                                                                v-bind="props"
                                                                size="small"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar la dimensión, resultado de la evaluación docente, en la que se requiere formación docente.</span>
                                                    </v-tooltip>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-text-field required v-model="form.AsignaturasFA" variant="solo">

                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-row justify="center">
                                            <v-col align="start" cols="5">
                                                <InputLabel for="contenido" value="Competencia(s) en la(s) que se requiere la Formación Docente"  />
                                            </v-col>
                                            <v-col align="start" cols="7" class="mb-0 pa-0">
                                                <div class="d-flex justify-start mb-5">
                                                    <v-tooltip
                                                        location="right"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                v-bind="props"
                                                                size="small"
                                                                color="blue-darken-1"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar las competencias en que requiere la formación docente</span>
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
                                                <InputLabel for="asignaturas" value="Asignatura(s) en la(s) que se requiere Actualización profesional"  />
                                            </v-col>
                                            <v-col align="start" cols="7" class="mb-0 pa-0">
                                                <div class="d-flex justify-start mb-5">
                                                    <v-tooltip
                                                        location="right"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                v-bind="props"
                                                                size="small"
                                                                color="blue-darken-1"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar el nombre de la(s) asignatura(s) en la(s) que se requiere Actualización Profesional.</span>
                                                    </v-tooltip>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-text-field required v-model="form.AsignaturasFA" variant="solo">

                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-row justify="center">
                                            <v-col align="start" cols="10">
                                                <InputLabel for="contenidosTM" value="Contenidos temáticos en que se requiere Actualización Profesional"  />
                                            </v-col>
                                            <v-col align="start" cols="2" class="mb-0 pa-0">
                                                <div class="d-flex justify-start mb-5">
                                                    <v-tooltip
                                                        location="right"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                v-bind="props"
                                                                size="small"
                                                                color="blue-darken-1"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar los contenidos temáticos de la asignatura que requiere la Actualización Profesional.</span>
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
                                <v-col cols="12">
                                    <v-row justify="center">
                                        <v-col align="start" cols="10" class="">
                                            <InputLabel for="lugar" value="Lugar en que se realizara o realizo el curso o actividad"/>
                                        </v-col>
                                        <v-col align="start" cols="2" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Indicar el lugar donde se realizara el curso</span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-select variant="solo" :items="lugar" item-value="id" item-title="nombreAula" v-model="form.id_lugar"></v-select>
                                </v-col>
                                <v-col cols="6" class="mt-1">
                                    <v-row justify="center">
                                        <v-col align="start" cols="10" class="">
                                            <template v-if="form.tipo === 1">
                                                <InputLabel for="numProfesores" value="Número de profesores(as) que requieren Formación Docente" />
                                            </template>
                                            <template v-else>
                                                <InputLabel for="numProfesores" value="Número de profesores(as) que requieren Actualización Profesional." />
                                            </template>
                                        </v-col>
                                        <v-col align="start" cols="2" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Indicar el número de profesores(as) que requieren Formación Docente o Actualización Profesional.</span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-text-field required v-model="form.Numprofesores" variant="solo">

                                    </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-row justify="center">
                                        <v-col align="start" cols="11">
                                            <template v-if="form.tipo === 1">
                                                <InputLabel for="periodo" value="Periodo en el que se requiere la Formación Docente (enero-junio o agosto-diciembre)"  />
                                            </template>
                                            <template v-else>
                                                <InputLabel for="periodo" value="Periodo en el que se requiere la Actualización Profesional (enero-junio o agosto-diciembre)"  />
                                            </template>
                                        </v-col>
                                        <v-col align="start" cols="1" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="left"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Indicar el periodo en el que se requiere la formación docente o actualización profesiona (enero-junio o agosto-diciembre)</span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-select required v-model="form.periodo"
                                              :items="period" item-title="text" item-value="value" variant="solo">

                                    </v-select>
                                </v-col>
                                <v-col cols="6">
                                    <v-row justify="center">
                                        <v-col align="start" cols="3">
                                            <InputLabel for="modalidad" value="Modalidad"  />
                                        </v-col>
                                        <v-col align="start" cols="9" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"

                                                            color="blue-darken-1"
                                                        >
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
                                    <v-select variant="solo" required :items="modalidad" item-title="text" item-value="value" v-model="form.modalidad" >

                                    </v-select>
                                </v-col>
                                <v-col cols="6">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="tipo_curso" value="Tipo de curso"  />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
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
                                    <v-select required :items="tipoCurso" item-title="text" item-value="value" v-model="form.tipo_act" variant="solo">

                                    </v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="carrera" value="PARA LOS(AS) PROFESORES(AS) DE LA ACADEMIA DE" />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
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
                                    <v-select required :items="props.carrera" item-title="nameCarrera" item-value="id" v-model="form.dirigido" variant="solo">

                                    </v-select>
                                </v-col>
                                <v-col>
                                    <v-row justify="center">
                                        <v-col align="start" cols="4">
                                            <InputLabel for="facilitador" value="Facilitador(a) que impartirá el curso/taller"  />
                                        </v-col>
                                        <v-col align="start" cols="4" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Anotar el nombre del facilitador (a) que impartirá el curso/taller.</span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-btn @click="dialogDocente = true" color="blue-darken-1">Crear Docente</v-btn>
                                            <create-docente-a
                                                :auth="props.auth"
                                                :carrera="props.carrera"
                                                :departamento="props.todos_los_departamentos"
                                                :posgrado="props.posgrado"
                                                :puesto="props.puesto"
                                                :tipo_plaza="props.tipo_plaza"
                                                v-model="dialogDocente"
                                                @update:modelValue="dialogDocente = $event"
                                                @docente-add="submitDocente"
                                            >

                                            </create-docente-a>
                                        </v-col>
                                    </v-row>
                                    <v-autocomplete multiple :items="props.docentes" item-title="nombre_completo" item-value="id" v-model="form.facilitadores" variant="solo">

                                    </v-autocomplete>
                                </v-col>
                                <v-col  align-self="center">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="facilitador_externo" value="Facilitador(a) externo que impartirá el curso/taller"  />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="top"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>En caso de que el facilitador sea externo</span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-text-field v-model="form.facilitador_externo"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="nombreCurso" value="Nombre del curso, taller, conferencias, etc."  />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <template v-if="form.tipo === 1">
                                                    <v-tooltip
                                                        location="bottom"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                v-bind="props"
                                                                size="small"
                                                                color="blue-darken-1"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar el nombre del curso, taller, conferencias, etc., que se llevarán a cabo para la Formación Docente del (de la) profesor(a) en las dimensiones de la Evaluación Docente.</span>
                                                    </v-tooltip>
                                                </template>
                                                <template v-else>
                                                    <v-tooltip
                                                        location="bottom"
                                                    >
                                                        <template v-slot:activator="{ props }">
                                                            <v-btn
                                                                icon
                                                                v-bind="props"
                                                                size="small"
                                                                color="blue-darken-1"
                                                            >
                                                                <v-icon>
                                                                    mdi-help
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Anotar el nombre del curso, taller, conferencias, etc., que se llevarán a cabo para la actualización profesional del (de la) profesor(a) en la(s) asignatura(s) que se requiere</span>
                                                    </v-tooltip>
                                                </template>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-text-field required v-model="form.nombreCT">

                                    </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-row justify="center">
                                        <v-col align="start" cols="8">
                                            <h4>Elegir las fechas en que se
                                                realizará la actividad
                                                o evento</h4>
                                        </v-col>
                                        <v-col align="start" cols="4" class="mb-0 pa-0">
                                            <div class="d-flex justify-start mb-5">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"

                                                            color="blue-darken-1"
                                                        >
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
                                            <v-text-field label="Inicio" required type="date" v-model="form.fecha_I"/>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field label="Termino" required type="date" v-model="form.fecha_F"/>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="6">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <h4>Elegir los horarios en que
                                                se realizará la
                                                actividad o
                                                evento</h4>
                                        </v-col>
                                        <v-col align="start" cols="7" class="mt-2 pa-0">
                                            <div class="d-flex justify-start mb-0">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"
                                                            color="blue-darken-1"
                                                        >
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
                                            <v-text-field label="Termino" class="" required type="time" v-model="form.hora_F"/>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col align-self="center" cols="12">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="objetivo" value="Objetivo de la actividad o evento"  />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-5 pa-0">
                                            <div class="d-flex justify-end mb-0">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"

                                                            color="blue-darken-1"
                                                        >
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
                                    <v-text-field required v-model="form.objetivo" >

                                    </v-text-field>
                                </v-col>
                                <v-col align-self="center" cols="12">
                                    <v-row justify="center">
                                        <v-col align="start" cols="5">
                                            <InputLabel for="observaciones" value="Introducir si la actividad o evento tiene observaciones"  />
                                        </v-col>
                                        <v-col align="start" cols="7" class="mb-5 pa-0">
                                            <div class="d-flex justify-end mb-0">
                                                <v-tooltip
                                                    location="right"
                                                >
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn
                                                            icon
                                                            v-bind="props"
                                                            size="small"

                                                            color="blue-darken-1"
                                                        >
                                                            <v-icon>
                                                                mdi-help
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Anotar si la actividad o evento tiene observaciones. </span>
                                                </v-tooltip>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-text-field v-model="form.observaciones" >

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
                    </form>
                </div>
            </div>
        </div>
        <CustomSnackBar :message="message" :color="color" v-model="snackbar" @update:model-value="snackbar = $event"></CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
