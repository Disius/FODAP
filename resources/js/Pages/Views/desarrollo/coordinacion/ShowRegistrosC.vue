<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";


const store = Curso()
const props = defineProps({
   cursos_fd: Array,
   auth: Object,
   cursos_ap: Array,
   departamento: Array,
   carrera: Array
});
const search = ref("");
const search_ap = ref("")
const anio_filter_fd = ref()
const anio_filter_ap = ref()
const departamento_filtro_fd = ref()
const departamento_filtro_ap = ref()
const carrera_fd = ref()
const carrera_ap = ref()

const filterCursoFD = computed(() => {
    const busqueda = search.value.toLowerCase().trim();
    const anio = anio_filter_fd.value;
    const departamento = departamento_filtro_fd.value
    const carrera = carrera_fd.value

    let cursosFiltrados = [...props.cursos_fd];

    if (busqueda) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.nombreCurso.toLowerCase().includes(busqueda)
        });
    }

    if (anio) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            const parse_anio = new Date(item.fecha_I).getFullYear()
            return parse_anio === anio
        });
    }
    if (departamento) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.id_departamento === departamento
        });
    }
    if (carrera) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.carrera_dirigido === carrera
        });
    }

    return cursosFiltrados;
});

const filterCursoAP = computed(() => {
    const busqueda = search_ap.value.toLowerCase().trim();
    const anio = anio_filter_ap.value;
    const departamento = departamento_filtro_ap.value
    const carrera = carrera_ap.value


    let cursosFiltrados = [...props.cursos_ap];

    if (busqueda) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.nombreCurso.toLowerCase().includes(busqueda)
        });
    }

    if (anio) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            const parse_anio = new Date(item.fecha_I).getFullYear()
            return parse_anio === anio
        });
    }
    if (departamento) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.id_departamento === departamento
        });
    }
    if (carrera) {
        cursosFiltrados = cursosFiltrados.filter(item => {
            return item.carrera_dirigido === carrera
        });
    }

    return cursosFiltrados;

});

const fullYears = computed(() => {
    const maxYears = new Date().getFullYear() + 1;
    const minYears = maxYears - 7;
    const years = [];
    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});

onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    });

    store.get_curso_desarrollo()
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de todos los cursos que se llevaron acabo</h2>
            <NavLink :href="route('index.desarrollo.cursos')" as="button">
                <v-btn icon="mdi-arrow-left"></v-btn>
            </NavLink>
        </template>

        <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cursos de Formación Docente</h2>
                <template v-if="props.cursos_fd.length !== 0">
                    <div class="grid grid-cols-3">
                        <div class="flex justify-center w-50 mt-6">
                            <v-text-field variant="solo" v-model="search" label="Buscar por nombre de curso" clearable></v-text-field>
                        </div>
                        <div class="flex justify-center">
                            <div class="flex justify-center w-50 mt-6">
                                <v-select variant="solo" v-model="anio_filter_fd" :items="fullYears" label="Filtrar por año"></v-select>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="flex justify-center w-50 mt-6">
                                <v-select variant="solo" v-model="departamento_filtro_fd" :items="props.departamento" label="Filtrar por departamento" item-value="id" item-title="nameDepartamento"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-start">
                        <div class="flex justify-center w-50 mt-6">
                            <v-select variant="solo" v-model="carrera_fd" :items="props.carrera" label="Filtrar por carrera" item-value="id" item-title="nameCarrera"></v-select>
                        </div>
                    </div>
                    <v-virtual-scroll
                        :items="filterCursoFD"
                        height="300"
                        item-height="50"
                        class="mt-4"

                    >
                        <template v-slot:default="{ item }">
                            <v-list-item>
                                <template v-slot:prepend>

                                </template>

                                <v-list-item-title>{{ item.nombreCurso }}</v-list-item-title>
                                <v-list-item-subtitle>
                                    {{item.asignaturaFA}}
                                </v-list-item-subtitle>
                                <template v-slot:append>
                                    <NavLink :href="route('index.desarrollo.inscritos', item.id)" type="button" as="button">
                                        <v-btn
                                            border
                                            flat
                                            size="large"
                                            class="text-none"
                                            text="Ver"
                                            prepend-icon="mdi-eye-arrow-right-outline"
                                        >
                                        </v-btn>
                                    </NavLink>
                                </template>
                            </v-list-item>
                        </template>
                    </v-virtual-scroll>
                </template>
                <template v-else>
                    <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                            <v-alert
                                color="blue-darken-1"
                                icon="mdi-alert-circle"
                                prominent
                            >
                                Sin registros.
                            </v-alert>
                        </div>
                    </div>
                </template>
            </div>
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cursos de Actualización Profesional</h2>
                <template v-if="props.cursos_ap !== null">
                    <div class="grid grid-cols-3">
                        <div class="flex justify-center w-50 mt-6">
                            <v-text-field variant="solo" v-model="search_ap" label="Buscar por nombre de curso"></v-text-field>
                        </div>
                        <div class="flex justify-center">
                            <div class="flex justify-center w-50 mt-6">
                                <v-select variant="solo" v-model="anio_filter_ap" :items="fullYears" label="Filtrar por año"></v-select>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="flex justify-center w-50 mt-6">
                                <v-select variant="solo" v-model="departamento_filtro_ap" :items="props.departamento" label="Filtrar por departamento" item-value="id" item-title="nameDepartamento"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-start">
                        <div class="flex justify-center w-50 mt-6">
                            <v-select variant="solo" v-model="carrera_ap" :items="props.carrera" label="Filtrar por carrera" item-value="id" item-title="nameCarrera"></v-select>
                        </div>
                    </div>
                    <v-virtual-scroll
                        :items="filterCursoAP"
                        height="300"
                        item-height="50"
                        class="mt-4"

                    >
                        <template v-slot:default="{ item }">
                            <v-list-item>
                                <template v-slot:prepend>

                                </template>

                                <v-list-item-title>{{ item.nombreCurso }}</v-list-item-title>
                                <v-list-item-subtitle>
                                    {{item.asignaturaFA}}
                                </v-list-item-subtitle>
                                <template v-slot:append>
                                    <NavLink :href="route('index.desarrollo.inscritos', item.id)" type="button" as="button">
                                        <v-btn
                                            border
                                            flat
                                            size="small"
                                            class="text-none"
                                            text="Ver"
                                            prepend-icon="mdi-eye-arrow-right-outline"
                                        >
                                        </v-btn>
                                    </NavLink>
                                </template>
                            </v-list-item>
                        </template>
                    </v-virtual-scroll>
                </template>
                <template v-else>
                    <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                            <v-alert
                                color="blue-darken-1"
                                icon="mdi-alert-circle"
                                prominent
                            >
                                Sin registros.
                            </v-alert>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>



</style>
