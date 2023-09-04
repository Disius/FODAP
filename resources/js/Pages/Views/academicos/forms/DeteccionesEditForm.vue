<script setup>
import {computed, onMounted, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    deteccion: Object,
    carrera: Array,
    docentes: Array,
    lugar: {
        type: Array
    },
});

const user = computed(() => usePage().props.auth.user);
let exist = ref(null)
const dialog = ref(true);
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
    id_jefe: user.value.docente_id,
    facilitador_externo: null,
    id_lugar: null,
});

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
    {value:5, text:"SEMINARIO"}
]);
const period = ref([
    {text: "ENERO-JUNIO", value: 1},
    {text: "AGOSTO-DICIEMBRE", value: 2},
]);

const carreraFilter = computed(() => {
    let filtro = props.carrera
    const addTodas =  {nameCarrera: "TODAS LAS CARRERAS", id: 11}

    filtro.push(addTodas);

    return filtro;
});
/* Este computed sirve para solo obtener el id, el objeto se obtiene a partir de la relacion que existe en los modelos
* no lo aplique en los modelos que devuelve el id porque lo uso en otras vistas, si hayas la forma de obtenerlo
* exelente!!!
* */
const idFacilitador = computed(() => {
   let facilitador = null

    for (let i of props.deteccion.deteccion_facilitador){
        facilitador = i.id
    }
    return facilitador
});
onMounted(() => {
    form.AsignaturasFA = props.deteccion.asignaturaFA
    form.ContenidoTFA = props.deteccion.contenidosTM
    form.Numprofesores = props.deteccion.numeroProfesores
    form.periodo = props.deteccion.periodo
    form.nombreCT = props.deteccion.nombreCurso
    form.fecha_I = props.deteccion.fecha_I
    form.fecha_F = props.deteccion.fecha_F
    form.hora_I = props.deteccion.hora_I
    form.hora_F =props.deteccion.hora_F
    form.tipo = props.deteccion.tipo_FDoAP
    form.tipo_act = props.deteccion.tipo_actividad
    form.dirigido = props.deteccion.carrera_dirigido
    form.objetivo = props.deteccion.objetivoEvento
    form.modalidad = props.deteccion.modalidad
    form.facilitador_externo = props.deteccion.facilitador_externo
    form.id_lugar = props.deteccion.id_lugar
    // !!!!
    form.facilitadores = idFacilitador.value
});
</script>

<template>
    <section>
        <form @submit.prevent="form.put(route('update.detecciones', props.deteccion.id))">
            <v-row justify="center">
                    <v-container class="mt-5">
                        <v-row justify="center">
                            <template v-if="form.tipo === 1">
                                <v-col cols="12" align-self="center">
                                    <v-text-field v-model="form.AsignaturasFA" label="Dimensión(es) en la(s) que se requiere Formación Docente">

                                    </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-textarea label="Competencia(s) en la(s) que se requiere la Formación Docente" v-model="form.ContenidoTFA" >

                                    </v-textarea>
                                </v-col>
                            </template>
                            <template v-if="form.tipo === 2">
                                <v-col cols="12" align-self="center">
                                    <v-text-field label="Asignatura(s) en la(s) que se requiere Actualización profesional" v-model="form.AsignaturasFA">

                                    </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-textarea label="Contenidos temáticos en que se requiere Actualización Profesional" v-model="form.ContenidoTFA" >

                                    </v-textarea>
                                </v-col>
                            </template>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12">
                                <InputLabel for="lugar" value="Lugar en que se realizara el curso o actividad"/>
                                    <v-select variant="solo" :items="props.lugar" item-value="id" item-title="nombreAula" v-model="form.id_lugar"></v-select>
                                    <v-tooltip
                                        location="right"
                                    >
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                icon
                                                v-bind="props"
                                                size="small"
                                            >
                                                <v-icon color="blue-lighten-1">
                                                    mdi-help
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Indicar el lugar donde se realizara el curso</span>
                                    </v-tooltip>
                            </v-col>
                            <v-col class="" cols="6">
                                <InputLabel for="tipo_solicitud" value="Tipo de solicitud" />
                                <v-row align="center" justify="center" class="mt-2">
                                    <v-select :items="tipoSolicitud" item-title="text" item-value="value"
                                              v-model="form.tipo">

                                    </v-select>
                                </v-row>
                            </v-col>
                            <v-col cols="6">
                                <InputLabel for="num_profesores" value="Numero de profesores(as) requeridos(as)"></InputLabel>
                                <v-text-field v-model="form.Numprofesores" >

                                </v-text-field>
                            </v-col>
                            <v-col cols="6" align-self="center">
                                <InputLabel for="periodo" value="Periodo de realización (enero-junio o agosto-diciembre)"  />
                                <v-select v-model="form.periodo"
                                          :items="period" item-title="text" item-value="value">

                                </v-select>
                            </v-col>
                            <v-col cols="6">
                                <InputLabel for="periodo" value="Modalidad"  />
                                <v-select :items="modalidad" item-title="text" item-value="value" v-model="form.modalidad" >

                                </v-select>
                            </v-col>
                            <v-col cols="6">
                                <InputLabel for="tipo_curso" value="Tipo de curso"  />
                                <v-select :items="tipoCurso" item-title="text" item-value="value" v-model="form.tipo_act" >

                                </v-select>
                            </v-col>
                            <v-col cols="12">
                                <InputLabel for="carrera" value="Carrera a la que va dirigida" />
                                <v-select :items="carreraFilter" item-title="nameCarrera" item-value="id" v-model="form.dirigido">

                                </v-select>
                            </v-col>
                            <v-col >
                                <v-autocomplete multiple label="Facilitadores" :items="props.docentes" item-title="nombre_completo" item-value="id" v-model="form.facilitadores">

                                </v-autocomplete>
                            </v-col>
                            <v-col cols="1" align-self="center">
                                <v-tooltip
                                    location="top"
                                >
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            icon
                                            v-bind="props"
                                            size="small"
                                            @click="exist = !exist"
                                        >
                                            <v-icon color="blue-lighten-1">
                                                mdi-help
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Si el facilitador es una institución</span>
                                </v-tooltip>
                            </v-col>
                            <v-col  align-self="center">
                                <v-text-field label="Faciltador" :disabled="!exist" v-model="form.facilitador_externo"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field label="Nombre del curso, taller, conferencias, etc." v-model="form.nombreCT">

                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <h4>Elegir las fechas en que se
                                    realizará la actividad
                                    o evento</h4>
                                <v-row justify="center">
                                    <v-col cols="6">
                                        <v-text-field type="date" v-model="form.fecha_I"/>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-text-field type="date" v-model="form.fecha_F"/>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="6">
                                <h4>Elegir los horarios en que
                                    se realizará la
                                    actividad o
                                    evento</h4>
                                <v-row justify="center">
                                    <v-col cols="6">
                                        <v-text-field type="time" v-model="form.hora_I"></v-text-field>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-text-field type="time" v-model="form.hora_F"/>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col align-self="center" cols="12">
                                <v-text-field v-model="form.objetivo" label="Objetivo de la actividad o evento" >

                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
            </v-row>
            <div class="flex justify-end mr-12 h-6 items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
