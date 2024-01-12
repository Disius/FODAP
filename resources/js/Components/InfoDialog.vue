<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, watch} from "vue";
import axios from "axios";
import {ref} from "vue";
import {Curso} from "@/store/curso.js";


const store = Curso()
const props = defineProps({
    modelValue: Boolean,
    curso: Object,
})

const emit = defineEmits([
    'update:modelValue'
])
const id = ref()
const course = ref({})
onMounted(() => {

})
// console.log(store.curso_In)
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue">
        <v-card width="500" height="700">
            <v-card-title>{{ store.curso_Info.nombreCurso }}</v-card-title>
            <v-card-text>
                <div class="flow-root ... pt-5">
                    <strong>Fecha de realización </strong>
                    {{store.curso_Info.fecha_I}} a {{store.curso_Info.fecha_F}}
                </div>
                <div class="flow-root ... pt-3">
                    <strong>Asignaturas en la que se requiere formación o actualización: </strong>
                    <v-divider></v-divider>
                    <span>{{store.curso_Info.asignaturaFA}}</span>
                </div>
                <div class="flow-root ... pt-7">
                    <strong>Contenidos temáticos en que se requiere la formación o actualización: </strong>
                    <v-divider></v-divider>
                    <span>{{store.curso_Info.contenidosTM}}</span>
                </div>
                <div class="flow-root ... pt-5">
                    <strong>Modalidad: </strong>
                    <template v-if="store.curso_Info.modalidad === 1">
                        <span>Virtual</span>
                    </template>
                    <template v-if="store.curso_Info.modalidad === 2">
                        <span>Presencial</span>
                    </template>
                    <template v-if="store.curso_Info.modalidad === 3">
                        <span>Hibrído</span>
                    </template>

                </div>
                <div class="flow-root ... pt-5">
                    <strong>Periodo en el que se requiere la formación o actualización (enero-junio o agosto diciembre): </strong>
                    <template v-if="store.curso_Info.periodo === 1">
                        <span>enero-junio</span>
                    </template>
                    <template v-if="store.curso_Info.periodo === 2  ">
                        <span>agosto-diciembre</span>
                    </template>
                </div>
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Carrera a la que va dirigido: </strong>-->
<!--                    <span>{{store.curso_Info.carrera.nameCarrera}}</span>-->
<!--                </div>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Lugar en el que se realizara el curso: </strong>-->
<!--                    <template v-if="store.curso_Info.lugar !== null">-->
<!--                        <span>{{store.curso_Info.lugar.nombreAula}}</span>-->
<!--                    </template>-->
<!--                    <template v-if="store.curso_Info.lugar === null">-->
<!--                        <span>A este curso no se le ha asignado una sala</span>-->
<!--                    </template>-->
<!--                </div>-->
                <div class="flow-root ... pt-5">
                    <strong>Facilitador(es): </strong>
                    <div v-for="facilitador in store.curso_Info.deteccion_facilitador">
                        <span>{{facilitador.nombre}}  {{facilitador.apellidoPat}}  {{facilitador.apellidoMat}}</span>
                    </div>
                </div>
<!--                <template v-if="props.curso.facilitador_externo != null">-->
<!--                    <div class="flow-root ... pt-5">-->
<!--                        <strong>Facilitador externo: </strong>-->
<!--                        <span>{{props.curso.facilitador_externo}}</span>-->
<!--                    </div>-->
<!--                </template>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Tipo de curso, taller, conferencias, etc: </strong>-->
<!--                    <template v-if="props.curso.tipo_actividad === 1">-->
<!--                        <span>TALLER</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_actividad === 2">-->
<!--                        <span>CURSO</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_actividad === 3">-->
<!--                        <span>CURSO-TALLER</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_actividad === 4">-->
<!--                        <span>FORO</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_actividad === 5">-->
<!--                        <span>SEMINARIO</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_actividad === 6">-->
<!--                        <span>DIPLOMADO</span>-->
<!--                    </template>-->
<!--                </div>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Tipo de solicitud: </strong>-->
<!--                    <template v-if="props.curso.tipo_FDoAP === 1">-->
<!--                        <span>FORMACIÓN DOCENTE</span>-->
<!--                    </template>-->
<!--                    <template v-if="props.curso.tipo_FDoAP === 2">-->
<!--                        <span>ACTUALIZACIÓN PROFESIONAL</span>-->
<!--                    </template>-->
<!--                </div>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Fechas en las que se realizara la actividad o evento: </strong>-->
<!--                    <span>Del {{props.curso.fecha_I}} al {{props.curso.fecha_F}}</span>-->
<!--                </div>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Horarios en las que se realizara la actividad o evento: </strong>-->
<!--                    <span>De {{props.curso.hora_I}} a {{props.curso.hora_F}}</span>-->
<!--                </div>-->
<!--                <div class="flow-root ... pt-5">-->
<!--                    <strong>Objetivo de la actividad o evento: </strong>-->
<!--                    <v-divider></v-divider>-->
<!--                    <span>{{props.curso.objetivoEvento}}</span>-->
<!--                </div>-->
<!--                <template v-if="props.curso.obs === 1">-->
<!--                    <div class="flow-root ... pt-5">-->
<!--                        <strong>Observaciones: </strong>-->
<!--                        <v-divider></v-divider>-->
<!--                        <span>{{props.curso.observaciones}}</span>-->
<!--                    </div>-->
<!--                </template>-->
            </v-card-text>
            <v-card-actions>
                <v-row justify="center">
                    <v-col  align="center" class="ml-16 pl-16">
                        <v-btn @click="emit('update:modelValue', false)" border
                               flat
                               size="x-large"
                               class="text-none"
                               color="error"
                            >
                            Cerrar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
