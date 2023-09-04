<script setup>

import {computed, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    carrera: {
        type: Array,
    },
    docente: {
        type: Array
    },
    todos_los_departamentos: {
        type: Array,
    },
    lugar: {
        type: Array
    }
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
    id_departamento: user.value.departamento_id,
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
</script>

<template>
    <section>
        <form @submit.prevent="form.post(route('store.detecciones'))">
            <v-dialog v-model="dialog" width="500" persistent>
                <v-card width="500" height="300">
                    <v-card-title class="text-center">Tipo de diagnostico que desea realizar</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-container class="mt-6">
                            <InputLabel for="tipo_solicitud" value="Tipo de solicitud" />
                            <v-row align="center" justify="center" class="mt-2">
                                <v-select :items="tipoSolicitud" item-title="text" item-value="value"
                                          v-model="form.tipo">

                                </v-select>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-divider></v-divider>
                        <div class="flex items-center mr-5 mb-7 justify-end gap-4">
                            <v-btn color="error" @click="dialog = false">
                                Cancelar
                            </v-btn>
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
                                <v-col cols="12" align-self="center">
                                    <InputLabel for="asignaturas" value="Dimensión(es) en la(s) que se requiere Formación Docente"  />
                                    <v-text-field required v-model="form.AsignaturasFA">

                                    </v-text-field>
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar la dimensión, resultado de la evaluación docente, en la que se requiere formación docente.</span>
                                    </v-tooltip>
                                </v-col>
                                <v-col cols="6">
                                    <InputLabel for="contenido" value="Competencia(s) en la(s) que se requiere la Formación Docente"  />
                                    <v-textarea required v-model="form.ContenidoTFA" >

                                    </v-textarea>
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar las competencias en que requiere la formación docente</span>
                                    </v-tooltip>
                                </v-col>
                            </template>
                            <template v-if="form.tipo === 2">
                                <v-col cols="12" align-self="center">
                                    <InputLabel for="asignaturas" value="Asignatura(s) en la(s) que se requiere Actualización profesional"  />
                                    <v-text-field required v-model="form.AsignaturasFA">

                                    </v-text-field>
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar el nombre de la(s) asignatura(s) en la(s) que se requiere Actualización Profesional.</span>
                                    </v-tooltip>
                                </v-col>
                                <v-col cols="6">
                                    <InputLabel for="periodo" value="Contenidos temáticos en que se requiere Actualización Profesional"  />
                                    <v-textarea required v-model="form.ContenidoTFA" >

                                    </v-textarea>
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar los contenidos temáticos de la asignatura que requiere la Actualización Profesional.</span>
                                    </v-tooltip>
                                </v-col>
                            </template>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12">
                                <v-select label="Lugar en que se realizara el curso o actividad" :items="lugar" item-value="id" item-title="nombreAula"></v-select>
                            </v-col>
                            <v-col cols="6" class="mt-1">
                                <template v-if="form.tipo === 1">
                                    <InputLabel for="numProfesores" value="Número de profesores(as) que requieren Formación Docente" />
                                </template>
                                <template v-else>
                                    <InputLabel for="numProfesores" value="Número de profesores(as) que requieren Actualización Profesional." />
                                </template>
                                <v-text-field required v-model="form.Numprofesores" >

                                </v-text-field>
                                <v-tooltip
                                    location="right"
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
                                    <span>Indicar el número de profesores(as) que requieren Formación Docente o Actualización Profesional.</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="6">
                                <template v-if="form.tipo === 1">
                                    <InputLabel for="periodo" value="Periodo en el que se requiere la Formación Docente (enero-junio o agosto-diciembre)"  />
                                </template>
                                <template v-else>
                                    <InputLabel for="periodo" value="Periodo en el que se requiere la Actualización Profesional (enero-junio o agosto-diciembre)"  />
                                </template>
                                <v-select required v-model="form.periodo"
                                          :items="period" item-title="text" item-value="value">

                                </v-select>
                                <v-tooltip
                                    location="bottom"
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
                                    <span>Indicar el periodo en el que se requiere la formación docente o actualización profesiona (enero-junio o agosto-diciembre)</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="6">
                                <InputLabel for="periodo" value="Modalidad"  />
                                <v-select required :items="modalidad" item-title="text" item-value="value" v-model="form.modalidad" >

                                </v-select>
                                <v-tooltip
                                    location="right"
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
                                    <span>La modalidad en la que se realizara el curso.</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="6">
                                <InputLabel for="tipo_curso" value="Tipo de curso"  />
                                <v-select required :items="tipoCurso" item-title="text" item-value="value" v-model="form.tipo_act" >

                                </v-select>
                                <v-tooltip
                                    location="right"
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
                                    <span>El tipo de curso.</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="12">
                                <InputLabel for="carrera" value="PARA LOS(AS) PROFESORES(AS) DE LA ACADEMIA DE" />
                                <v-select required :items="carreraFilter" item-title="nameCarrera" item-value="id" v-model="form.dirigido">

                                </v-select>
                            </v-col>
                            <v-col>
                                <InputLabel for="facilitador" value="Facilitador(a) que impartirá el curso/taller"  />
                                <v-autocomplete multiple :items="props.docente" item-title="nombre_completo" item-value="id" v-model="form.facilitadores">

                                </v-autocomplete>
                            </v-col>
                            <v-col cols="1" class="mt-9 ml-7">
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
                                    <span>En caso de que el facilitador sea externo</span>
                                </v-tooltip>
                            </v-col>
                            <v-col  align-self="center">
                                <InputLabel for="facilitador_externo" value="Facilitador(a) externo que impartirá el curso/taller"  />
                                <v-text-field required :disabled="!exist" v-model="form.facilitador_externo"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <InputLabel for="nombreCurso" value="Nombre del curso, taller, conferencias, etc."  />
                                <v-text-field required v-model="form.nombreCT">

                                </v-text-field>
                                <template v-if="form.tipo === 1">
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar el nombre del curso, taller, conferencias, etc., que se llevarán a cabo para la Formación Docente del (de la) profesor(a) en las dimensiones de la Evaluación Docente.</span>
                                    </v-tooltip>
                                </template>
                                <template v-else>
                                    <v-tooltip
                                        location="right"
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
                                        <span>Anotar el nombre del curso, taller, conferencias, etc., que se llevarán a cabo para la actualización profesional del (de la) profesor(a) en la(s) asignatura(s) que se requiere</span>
                                    </v-tooltip>
                                </template>
                            </v-col>
                            <v-col cols="6">
                                <h4>Elegir las fechas en que se
                                    realizará la actividad
                                    o evento</h4>
                                <v-row justify="center">
                                    <v-col cols="6">
                                        <v-text-field required type="date" v-model="form.fecha_I"/>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-text-field required type="date" v-model="form.fecha_F"/>
                                    </v-col>
                                </v-row>
                                <v-tooltip
                                    location="right"
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
                                    <span>Anotar la fecha en que se realizará la actividad o evento</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="6">
                                <h4>Elegir los horarios en que
                                    se realizará la
                                    actividad o
                                    evento</h4>
                                <v-row justify="center">
                                    <v-col cols="6" align="center" class="mt-4">
                                        <input required type="time" v-model="form.hora_I" />
                                    </v-col>
                                    <v-col cols="6">
<!--                                        <InputLabel for="time" valuet="kd"/>-->
                                        <input class="mt-4" required type="time" v-model="form.hora_F"/>
                                    </v-col>
                                </v-row>
                                <v-tooltip
                                    location="right"
                                >
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            icon
                                            v-bind="props"
                                            size="small"
                                            @click="exist = !exist"
                                            class="mt-5"
                                        >
                                            <v-icon color="blue-lighten-1">
                                                mdi-help
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Indicar el horario en que se realizará la actividad o evento</span>
                                </v-tooltip>
                            </v-col>
                            <v-col align-self="center" cols="12">
                                <v-text-field required v-model="form.objetivo" label="Objetivo de la actividad o evento" >

                                </v-text-field>
                                <v-tooltip
                                    location="right"
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
                                    <span>Anotar el objetivo de la actividad o evento. </span>
                                </v-tooltip>
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
    </section>
</template>

<style scoped>

</style>
