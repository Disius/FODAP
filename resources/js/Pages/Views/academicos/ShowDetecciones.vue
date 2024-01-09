<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref, computed, onMounted} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {Head} from "@inertiajs/vue3";


const props = defineProps({
    deteccion: {
        type: Object
    },
    auth: Object
});


// const formatFechaF = computed(() => {
//     return new Date(props.deteccion.fecha_F).toLocaleDateString('es-MX');
// })
// // Computed propierties
//
//
// const formatFechaI = computed(() => {
//     return new Date(props.deteccion.fecha_I).toLocaleDateString('es-MX');
// });
// const dialog = ref(true);
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
    })
});
</script>

<template>
    <template v-if="props.deteccion === null">
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>
                <div class="flex justify-start align-center mt-3 ml-5">
                    <NavLink :href="route('detecciones.index')" as="button" type="button">
                        <v-btn color="blue-darken-1" icon="mdi-arrow-left"></v-btn>
                    </NavLink>
                </div>
            </template>
            <v-alert
                icon="$info"
                color="info"
            >
                <strong>Probablemente este registo fue eliminado</strong>
            </v-alert>
        </AuthenticatedLayout>
    </template>
    <template v-else>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{props.deteccion.nombreCurso}}</h2>
                <div class="flex justify-start align-center mt-3 ml-5">
                    <NavLink :href="route('detecciones.index')" as="button" type="button">
                        <v-btn color="blue-darken-1" icon="mdi-arrow-left"></v-btn>
                    </NavLink>
                </div>
                <template v-if="props.deteccion.aceptado === 0">
                    <div class="mt-6">
                        <NavLink :href="route('edit.detecciones', props.deteccion.id)" type="button" as="button">
                            <v-btn prepend-icon="mdi-pencil" class="" color="blue-darken-1">
                                Editar
                            </v-btn>
                        </NavLink>
                    </div>
                </template>
            </template>

            <div class="pt-5">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex items-center">
                            <div>
                                <div class="p-5">
                                    <div class="flow-root ...">
                                        <strong class="text-xl">Asignaturas en la que se requiere formación o actualización: </strong>
                                        <v-divider></v-divider>
                                        <span>{{props.deteccion.asignaturaFA}}</span>
                                    </div>
                                    <div class="flow-root ... pt-7">
                                        <strong class="text-xl">Contenidos temáticos en que se requiere la formación o actualización: </strong>
                                        <v-divider></v-divider>
                                        <span>{{props.deteccion.contenidosTM}}</span>
                                    </div>
                                    <div class="flow-root ... pt-7">
                                        <strong class="text-xl">Número de profesores(as) que la requieren: </strong>
                                        <span>{{props.deteccion.numeroProfesores}}</span>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Modalidad: </strong>
                                        <template v-if="props.deteccion.modalidad === 1">
                                            <span>Virtual</span>
                                        </template>
                                        <template v-if="props.deteccion.modalidad === 2">
                                            <span>Presencial</span>
                                        </template>
                                        <template v-if="props.deteccion.modalidad === 3">
                                            <span>Hibrído</span>
                                        </template>

                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Periodo en el que se requiere la formación o actualización (enero-junio o agosto diciembre): </strong>
                                        <template v-if="props.deteccion.periodo === 1">
                                            <span>ENERO-JUNIO</span>
                                        </template>
                                        <template v-if="props.deteccion.periodo === 2  ">
                                            <span>AGOSTO-DICIEMBRE</span>
                                        </template>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Carrera a la que va dirigido: </strong>
                                        <span>{{props.deteccion.carrera.nameCarrera}}</span>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Facilitador(es): </strong>
                                        <div v-for="facilitador in props.deteccion.deteccion_facilitador">
                                            <span>{{facilitador.nombre}}  {{facilitador.apellidoPat}}  {{facilitador.apellidoMat}}</span>
                                        </div>
                                    </div>
                                    <template v-if="props.deteccion.facilitador_externo != null">
                                        <div class="flow-root ... pt-5">
                                            <strong class="text-xl">Facilitador externo: </strong>
                                            <span>{{props.deteccion.facilitador_externo}}</span>
                                        </div>
                                    </template>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Tipo de curso, taller, conferencias, etc: </strong>
                                        <template v-if="props.deteccion.tipo_actividad === 1">
                                            <span>TALLER</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_actividad === 2">
                                            <span>CURSO</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_actividad === 3">
                                            <span>CURSO-TALLER</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_actividad === 4">
                                            <span>FORO</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_actividad === 5">
                                            <span>SEMINARIO</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_actividad === 6">
                                            <span>DIPLOMADO</span>
                                        </template>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Tipo de solicitud: </strong>
                                        <template v-if="props.deteccion.tipo_FDoAP === 1">
                                            <span>FORMACIÓN DOCENTE</span>
                                        </template>
                                        <template v-if="props.deteccion.tipo_FDoAP === 2">
                                            <span>ACTUALIZACIÓN PROFESIONAL</span>
                                        </template>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Fechas en las que se realizara la actividad o evento: </strong>
                                        <span>Del {{props.deteccion.fecha_I}} al {{props.deteccion.fecha_F}}</span>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Horarios en las que se realizara la actividad o evento: </strong>
                                        <span>De {{props.deteccion.hora_I}} a {{props.deteccion.hora_F}}</span>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Horas totales de la actividad o evento: </strong>
                                        <span>{{props.deteccion.total_horas}}</span>
                                    </div>
                                    <div class="flow-root ... pt-5">
                                        <strong class="text-xl">Objetivo de la actividad o evento: </strong>
                                        <v-divider></v-divider>
                                        <span>{{props.deteccion.objetivoEvento}}</span>
                                    </div>
                                    <template v-if="props.deteccion.obs === 1">
                                        <div class="flow-root ... pt-5 ">
                                            <strong>Observaciones: </strong>
                                            <v-alert
                                                border="bottom"
                                                border-color="warning accent-5"
                                                elevation="2"
                                            >
                                                <strong class="text-xl"> {{props.deteccion.observaciones}}</strong>
                                            </v-alert>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
</template>

<style scoped>
span{
    font-size: large;
}
</style>
