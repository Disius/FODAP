<script setup>
import {useForm} from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    modelValue: Boolean,
    curso: Number,
    docente: Number,
    calificacion: Number
})

const formCalificacion = useForm({
    calificacion: props.calificacion,
    docente_id: props.docente,
    curso_id: props.curso
})

watch(() => [props.docente, props.curso, props.calificacion], ([newDocente, newCurso, newCalificacion]) => {
    formCalificacion.docente_id = newDocente;
    formCalificacion.curso_id = newCurso;
    formCalificacion.calificacion = newCalificacion
    // console.log(newDocente, newCurso)
});
const emit = defineEmits([
    'update:modelValue',
    'update:Calificacion'
])

const submit = () => {
    emit('update:Calificacion', formCalificacion)
}
</script>

<template>
            <v-dialog width="auto" v-model="props.modelValue" persistent>
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
                            <v-col  align="end" class="ml-16 pl-16">
                                <danger-button @click="emit('update:modelValue', false)">
                                    Cerrar
                                </danger-button>
                            </v-col>
                            <v-col  align="end" class="mr-6">
                                <primary-button @click="submit">Actualizar</primary-button>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-dialog>
</template>

<style scoped>

</style>
