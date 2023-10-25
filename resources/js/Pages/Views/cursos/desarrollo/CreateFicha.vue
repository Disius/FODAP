<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted, ref} from "vue";

const props = defineProps({
    auth: Object,
    docente: Object,
    curso: Object,
})


const number_temas = ref(3);
const textFields = ref([]);

const form = useForm({
    id_curso: props.curso.id,
    introduccion: "",
    justificacion: "",
    objetivo_general: "",
    descripcion_servicio: "",
});

onMounted(() => {
    for (let i = 0; i < number_temas.value; i++) {
        textFields.value.push({ value: '' });
    }
})
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
                <div class="flex justify-start">
                    <strong class="text-xl">Temas: </strong>
                    <div class="d-flex justify-start mb-5 ml-3">
                        <v-tooltip location="right">
                            <template v-slot:activator="{ props }">
                                <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                    <v-icon>
                                        mdi-help
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Debe indicar el número de temas que contendra la ficha técnica.</span>
                        </v-tooltip>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="flex justify-start w-25">
                        <v-text-field variant="solo" v-model="number_temas"></v-text-field>
                    </div>
                </div>
                <div class="grid grid-flow-row auto-cols-max gap-x-8 gap-y-4">
                    <div class="flex justify-center m-5">
                        <v-text-field variant="solo"
                                      v-for="(field, index) in number_temas"
                                      :key="index"
                                      v-model="field.value"
                        ></v-text-field>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
