<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GraficaCursos from "@/Pages/Views/desarrollo/estadisticas/components/GraficaCursos.vue";
import {computed, ref} from "vue";

const props = defineProps({
    cursos_anio: Number,
    cursos_periodos: Array,
})

const date = computed(() => {
    let date = new Date();
    return date.getFullYear()
})

console.log(props.cursos_periodos)
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Estadisticas</h2>
        </template>

        <div>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-center">
                        <h2 class="text-6xl font-semibold text-gray-900">Cursos</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3">
                        <div class="flex justify-center">
                            <div class="bg-gradient-to-b from-white to-blue-200 p-4 mt-2 sm:p-8 shadow sm:rounded-lg">
                                <div class="flex justify-center">
                                    <h2 class="text-lg font-medium text-gray-900">Total de cursos realizados en {{date}}</h2>
                                </div>
                                <div class="container mx-auto">
                                    <p class="font-semibold pa-5 text-center text-6xl mt-5">
                                        {{props.cursos_anio}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="bg-gradient-to-b from-white to-blue-200 p-4 mt-2 sm:p-8 shadow sm:rounded-lg">
                                <div class="flex justify-center">
                                    <h2 class="text-lg font-medium text-gray-900">Total de cursos realizados en el periodo enero-junio de {{date}}</h2>
                                </div>
                                <div class="container mx-auto mt-7">
                                    <p class="font-semibold pa-5 text-center text-6xl">
                                        {{props.cursos_periodos[0]}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="bg-gradient-to-b from-white to-blue-200 p-4 mt-2 sm:p-8 shadow sm:rounded-lg">
                                <div class="flex justify-center">
                                    <h2 class="text-lg font-medium text-gray-900">Total de cursos realizados en el periodo agosto-diciembre de {{date}}</h2>
                                </div>
                                <div class="container mx-auto">
                                    <p class="font-semibold pa-5 text-center text-6xl">
                                        {{props.cursos_periodos[1]}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>

</style>
