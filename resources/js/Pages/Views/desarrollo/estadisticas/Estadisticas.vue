<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";
import {useForm} from "@inertiajs/vue3"
import InputLabel from "@/Components/InputLabel.vue";
import Loading from "@/Components/Loading.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";


const props = defineProps({
    cursos_anio: Number,
    cursos_periodos: Array,
    cursos_tipo: Array,
    docente_carrera: Array,
    total_cursos_ap_fd: Array,
})
const showingNavigationDropdown = ref(false)
const showingNavigationDropdown2 = ref(false)
const showingNavigationDropdown3 = ref(false)
const showingNavigationDropdown4 = ref(false)
const loading = ref(false);
const message = ref("");
const color = ref("");
const timeout = ref();
const snackbar = ref(false)

const date = computed(() => {
    let date = new Date();
    return date.getFullYear()
})

const request_anio = useForm({
    anio: null
})

function download_excel_tipo(){
    loading.value = true
    axios.get(route('excel.cursos.tipo')).then(res => {
            loading.value = false
            const url = '/storage/estadisticas_tipo.xlsx';
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'estadisticas_tipo.xlsx');
            document.body.appendChild(link);
            link.click();
            snackbar.value = true
            color.value = "success"
            timeout.value = 5000
            message.value = "Excel generado con exito"
            setTimeout(() => {
            snackbar.value = true
        }, timeout.value)
    }).catch(error => {
        snackbar.value = true
        color.value = "error"
        timeout.value = 5000
        message.value = "El archivo no se pudo descargar"
        setTimeout(() => {
            snackbar.value = false
        }, timeout.value)
        console.log(error)

    })
}

function download_excel_periodos(){
    loading.value = true;
    axios.get(route('reporte.periodos')).then(res => {
        loading.value = false
        const url = '/storage/periodos.xlsx'
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', 'periodos.xlsx')
        document.body.appendChild(link)
        snackbar.value = true
        color.value = "success"
        timeout.value = 5000
        message.value = "Excel generado con exito"
           setTimeout(() => {
            snackbar.value = true
            }, timeout.value)
        link.click()
    }).catch(error => {
        loading.value = false
        snackbar.value = true
        color.value = "error"
        timeout.value = 5000
        message.value = "El archivo no se pudo descargar"
        setTimeout(() => {
            snackbar.value = false
        }, timeout.value)
        console.log(error)
    })
}

const fullYears = computed(() => {
    const maxYears = new Date().getFullYear() + 1;
    const minYears = maxYears - 2;
    const years = [];

    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-medium text-gray-900">Estadisticas</h2>
        </template>

        <div class="">
            <CustomSnackBar :message="message" :color="color" v-model="snackbar" @update:model-value="snackbar = $event">

            </CustomSnackBar>
            <Loading v-model="loading" @update:loading="loading = $event">
                <v-fade-transition leave-absolute>
                    <v-progress-circular
                        v-if="loading"
                        color="info"
                        :size="64"
                        :width="7"
                        indeterminate
                    ></v-progress-circular>
                </v-fade-transition>
            </Loading>
        </div>
        <div>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="flex justify-start">
                            <InputLabel for="anio" value="Seleccionar año de estadisticas" />
                        </div>
                        <div class="flex justify-end">
                            <v-select variant="solo" class="w-48" :items="fullYears" style="width: 20px;" v-model="request_anio.anio">
                            
                            </v-select>
                        </div>
                        <div class="flex justify-start ml-10 items-center">
                            <v-btn icon="mdi-calendar-search" color="blue-darken"></v-btn>
                        </div>
                    </div>

                    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-7xl w-full hover:brightness-100 ma-10">
                        <div class="grid gap-5 grid-cols-1 md:grid-cols-2">
                            <div class="flex justify-center items-center">
                                <p class="text-center text-4xl ma-5">Cursos realizados en {{date}}</p>
                            </div>
                            <div class="flex justify-center items-center">
                                <p class="text-center font-bold text-4xl ma-5">{{props.cursos_anio}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-7xl w-full hover:brightness-100 ma-10">
                        <div class="flex justify-center">
                            <div class="grid grid-cols-2 md:grid-cols-2"  @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <p class="ma-10 text-center text-2xl">Total de "Tipos de curso"</p>
                                <div class="flex justify-center items-center mt-2">
                                    <v-icon>mdi-arrow-down-drop-circle-outline</v-icon>
                                </div>
                            </div>
                        </div>
                        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }">
                            <div class="flex justify-end mr-10">
                                <v-btn
                                    prepend-icon="mdi-microsoft-excel"
                                    color="green-lighten-1"
                                    @click="download_excel_tipo"
                                >
                                    Generar Excel
                                </v-btn>
                            </div>
                            <div class="flex justify-center ma-10">
                                <table class="table-auto border-collapse border-2 border-black">
                                    <thead>
                                    <tr>
                                        <th class="border-2 border-black">Tipo de curso</th>
                                        <th class="border-2 border-black pa-2">Total de "tipo de curso" en {{date}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(c, i) in props.cursos_tipo" :key="i">
                                        <td class="border-2 border-black pa-2">
                                            <p class="text-center text-xl text-gray-900 pa-5">
                                                {{c.tipo}}
                                            </p>
                                        </td>
                                        <td class="border-2 border-black">
                                            <p class="text-center font-bold text-2xl">
                                                {{c.total}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-7xl w-full hover:brightness-100 ma-10">
                        <div class="flex justify-center">
                            <div class="grid grid-cols-2 md:grid-cols-2"  @click="showingNavigationDropdown2 = !showingNavigationDropdown2">
                                <p class="ma-10 text-center text-2xl">Total de cursos por periodo (enero-junio / agosto-diciembre)</p>
                                <div class="flex justify-center items-center mt-2">
                                    <v-icon>mdi-arrow-down-drop-circle-outline</v-icon>
                                </div>
                            </div>
                        </div>
                        <div :class="{ block: showingNavigationDropdown2, hidden: !showingNavigationDropdown2 }">
                            <div class="flex justify-end mr-16">
                                <v-btn
                                    prepend-icon="mdi-microsoft-excel"
                                    color="green-lighten-1"
                                    @click="download_excel_periodos"
                                >
                                    Generar Excel
                                </v-btn>
                            </div>
                            <div class="flex justify-center ma-10">
                                <table class="table-auto border-collapse border-2 border-black">
                                    <thead>
                                    <tr>
                                        <th class="border-2 border-black">Periodo</th>
                                        <th class="border-2 border-black pa-2">Total de cursos {{date}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(p, i) in props.cursos_periodos" :key="i">
                                        <td class="border-2 border-black pa-2">
                                            <p class="text-center text-xl text-gray-900 pa-5">
                                                {{p.periodo}}
                                            </p>
                                        </td>
                                        <td class="border-2 border-black">
                                            <p class="text-center font-bold text-2xl">
                                                {{p.total}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-7xl w-full hover:brightness-100 ma-10">
                        <div class="flex justify-center">
                            <div class="grid grid-cols-2 md:grid-cols-2" @click="showingNavigationDropdown3 = !showingNavigationDropdown3">
                                <p class="ma-10 text-center text-2xl">Total de docentes capacitados por carrera en {{date}}</p>
                                <div class="flex justify-center items-center mt-2">
                                    <v-icon>mdi-arrow-down-drop-circle-outline</v-icon>
                                </div>
                            </div>
                        </div>
                        <div :class="{ block: showingNavigationDropdown3, hidden: !showingNavigationDropdown3 }">
                            <div class="flex justify-end mr-16">
                                <v-btn
                                    prepend-icon="mdi-microsoft-excel"
                                    color="green-lighten-1"
                                    @click="download_excel_periodos"
                                >
                                    Generar Excel
                                </v-btn>
                            </div>
                            <div class="ma-10 flex justify-center">
                                <table class="table-auto border-collapse border-2 border-black">
                                    <thead>
                                        <tr>
                                            <th class="border-2 border-black">Carrera</th>
                                            <th class="border-2 border-black pa-2">Total de docentes capacitados en {{date}}</th>
                                            <th class="border-2 border-black pa-2">Total de docentes masculinos</th>
                                            <th class="border-2 border-black pa-2">Total de docentes femeninos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(t, i) in props.docente_carrera" :key="i">
                                            <td class="border-2 border-black">
                                                <p class="text-center text-xl text-gray-900 pa-2">
                                                    {{t.carrera}}
                                                </p>
                                            </td>
                                            <td class="border-2 border-black">
                                                <p class="text-center font-bold text-2xl">
                                                    {{t.total}}
                                                </p>
                                            </td>
                                            <td class="border-2 border-black">
                                                <p class="text-center font-bold text-2xl">
                                                    {{t.Total_de_hombres_capacitados}}
                                                </p>
                                            </td>
                                            <td class="border-2 border-black">
                                                <p class="text-center font-bold text-2xl">
                                                    {{t.Total_de_mujeres_capacitadas}}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-7xl w-full hover:brightness-100 ma-10">
                        <div class="flex justify-center">
                            <div class="grid grid-cols-2 md:grid-cols-2" @click="showingNavigationDropdown4 = !showingNavigationDropdown4">
                                <p class="ma-10 text-center text-2xl">Total de cursos de formación docente y actualización profesional en {{date}}</p>
                                <div class="flex justify-center items-center mt-2">
                                    <v-icon>mdi-arrow-down-drop-circle-outline</v-icon>
                                </div>
                            </div>
                        </div>
                        <div :class="{ block: showingNavigationDropdown4, hidden: !showingNavigationDropdown4 }">
                            <div class="ma-10 flex justify-center">
                                <table class="table-auto border-collapse border-2 border-black">
                                    <thead>
                                        <tr>
                                            <th class="border-2 border-black">Tipo</th>
                                            <th class="border-2 border-black pa-2">Total en {{date}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(t, i) in props.total_cursos_ap_fd" :key="i">
                                            <td class="border-2 border-black">
                                                <p class="text-center text-xl text-gray-900 pa-2">
                                                    {{t.tipo}}
                                                </p>
                                            </td>
                                            <td class="border-2 border-black">
                                                <p class="text-center font-bold text-2xl">
                                                    {{t.total}}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
