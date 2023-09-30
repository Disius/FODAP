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
    temas: "",
    actividades_aprendizaje: "",
    elementos_didacticos: "",
    criterio_evaluacion: "",
    competencias: "",
    bibliografia: "",
});


const criterio = 3;


</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Crear Ficha Técnica</h2>
        </template>
        <div class="mt-5 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="grid grid-cols-1">
                    <div class="flex justify-center">
                        <InputLabel class="mr-5" for="introduccion" value="Introducción: "/>
                        <v-textarea variant="solo" v-model="form.introduccion"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="flex justify-center ">
                        <InputLabel class="mr-4" for="justificacion" value="Justificación: "/>
                        <v-textarea variant="solo" v-model="form.justificacion"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 justify-center">
                    <div class="flex justify-center">
                        <InputLabel class="mr-1" for="objetivo" value="Objetivo General: "/>
                        <v-textarea variant="solo" v-model="form.objetivo_general"></v-textarea>
                    </div>
                </div>
                <div class="grid grid-cols-2">
                    <div class="flex justify-center">
                        <InputLabel class="mr-1" for="objetivo" value="Actividades de aprendizaje: "/>
                        <v-textarea variant="solo" v-model="form.actividades_aprendizaje"></v-textarea>
                    </div>
                    <div class="flex justify-center ml-5">
                        <InputLabel class="mr-3" for="justificacion" value="Elementos didacticos: "/>
                        <v-textarea variant="solo" v-model="form.elementos_didacticos"></v-textarea>
                    </div>
                </div>
                <div class="flex justify-center">
                    <InputLabel for="Criterios" value="Criterios de Evaluación"/>
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
                        <v-card elevation="0" width="1000">
                            <v-table>
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="text-center">Criterio</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="c in criterio">
                                    <td class="w-20">
                                        {{c}}
                                    </td>
                                    <td class="w-50">
                                        <v-text-field v-model="form.criterio_evaluacion"></v-text-field>
                                    </td>
                                    <td>
                                        <v-text-field></v-text-field>
                                    </td>
                                </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
