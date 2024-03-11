<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";


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
const date = computed(() => {
    let date = new Date();
    return date.getFullYear()
})

function download_excel_tipo(){
    axios.get(route('excel.cursos.tipo')).then(res => {
            const url = '/storage/estadisticas_tipo.xlsx';
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'estadisticas_tipo.xlsx');
            document.body.appendChild(link);
            link.click();
    }).catch(error => {
        console.log(error)

    })
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-medium text-gray-900">Estadisticas</h2>
        </template>

        <div>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
<!--                    <div class="flex justify-end mr-16">-->
<!--&lt;!&ndash;                        <Link :href="route('download.cursos.excel')" as="button">&ndash;&gt;-->
<!--                            <v-btn-->
<!--                                prepend-icon="mdi-microsoft-excel"-->
<!--                                color="green-lighten-1"-->
<!--                                @click="download_excel"-->
<!--                            >-->
<!--                                Generar Excel-->
<!--                            </v-btn>-->
<!--&lt;!&ndash;                        </Link>&ndash;&gt;-->
<!--                    </div>-->
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
                            <div class="ma-10 flex justify-center">
                                <table class="table-auto border-collapse border-2 border-black">
                                    <thead>
                                        <tr>
                                            <th class="border-2 border-black">Carrera</th>
                                            <th class="border-2 border-black pa-2">Total de docentes capacitados en {{date}}</th>
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
