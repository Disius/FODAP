<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    auth: Object,
    docente: Object,
    curso: Object,
})

const form = useForm({
    id_curso: props.curso.id,
    introduccion: "",
    justificacion: "",
    objetivo_general: "",
    descripcion_servicio: "",
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Crear Ficha Técnica</h2>
        </template>
        <div class="mt-5 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="grid grid-cols-1">
                    <strong class="text-xl">Introducción: </strong>
                    <div class="flex justify-center mt-2">
                        <v-textarea variant="solo" v-model="form.introduccion"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <strong class="text-xl">Justificación: </strong>
                    <div class="flex justify-center mt-2">
                        <v-textarea variant="solo" v-model="form.justificacion"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 justify-center">
                    <strong class="text-xl">Objetivo General: </strong>
                    <div class="flex justify-center mt-2">
                        <v-textarea variant="solo" v-model="form.objetivo_general"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 justify-center">
                    <strong class="text-xl">Descripción del servicio: </strong>
                    <div class="flex justify-center mt-2">
                        <v-textarea variant="solo" v-model="form.descripcion_servicio"></v-textarea>
                    </div>
                </div>
                <div class="flex justify-center">
                    <InputLabel for="Criterios" value="Criterios de Evaluación"/>
                    <div class="d-flex justify-start mb-5 ml-3">
                        <v-tooltip location="right">
                            <template v-slot:activator="{ props }">
                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                    <v-icon>
                                        mdi-help
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Especificar los criterios de evaluación (minimo 3 criterio), Porcentaje asignado a cada criterio de evaluación.</span>
                        </v-tooltip>
                    </div>
                </div>
<!--                    <div class="flex justify-center">-->
<!--                        <InputLabel class="mr-1" for="objetivo" value="Actividades de aprendizaje: "/>-->
<!--                        <v-textarea variant="solo" v-model="form.actividades_aprendizaje"></v-textarea>-->
<!--                    </div>-->
<!--                    <div class="flex justify-center ml-5">-->
<!--                        <InputLabel class="mr-3" for="justificacion" value="Elementos didacticos: "/>-->
<!--                        <v-textarea variant="solo" v-model="form.elementos_didacticos"></v-textarea>-->
<!--                    </div>-->
                    <div class="flex justify-center w-100">
                        <v-textarea>

                        </v-textarea>
                    </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
