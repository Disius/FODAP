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
console.log(store.curso_Info)
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

<!--                <template v-if="store.curso_Info.deteccion_facilitador.length !== 0">-->
<!--                    <div class="flow-root ... pt-5">-->
<!--                        <strong>Facilitador(es): </strong>-->
<!--                        <div v-for="facilitador in store.curso_Info.deteccion_facilitador">-->
<!--                            <span>{{facilitador.nombre}}  {{facilitador.apellidoPat}}  {{facilitador.apellidoMat}}</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </template>-->
                <template v-if="store.curso_Info.facilitador_externo !== null">
                    <div class="flow-root ... pt-5">
                        <strong>Facilitador(es): </strong>
<!--                        <div v-for="facilitador in store.curso_Info.deteccion_facilitador">-->
                            <span>{{store.curso_Info.facilitador_externo}}</span>
<!--                        </div>-->
                    </div>
                </template>

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
