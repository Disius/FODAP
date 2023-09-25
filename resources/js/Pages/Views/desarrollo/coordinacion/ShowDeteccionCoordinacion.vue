<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaDetecciones from "@/Pages/Views/desarrollo/tablas/TablaDetecciones.vue";
import {computed, onMounted} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm, Head, router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    deteccion: Object,
    auth: Object
});

const formatFechaF = computed(() => {
    return new Date(props.deteccion.fecha_F).toLocaleDateString('es-MX');
})
// Computed propierties


const formatFechaI = computed(() => {
    return new Date(props.deteccion.fecha_I).toLocaleDateString('es-MX');
});

const form = useForm({
    observaciones: "",
});

const formAceptado = useForm({
    aceptado: 1,
})


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
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{props.deteccion.nombreCurso}}</h2>
            <template v-if="props.deteccion.aceptado === 0">
                <form @submit.prevent="formAceptado.post(route('store.aceptado', props.deteccion.id))">
                    <PrimaryButton class="mt-5">Aceptar Deteccion de Necesidades</PrimaryButton>
                </form>
            </template>
            <template v-if="props.deteccion.aceptado === 1">
                <div class="flex justify-start align-center mt-3 ml-5">
                    <NavLink :href="route('curso.editar', props.deteccion.id)">
                        <primary-button>Editar</primary-button>
                    </NavLink>
                </div>
            </template>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center">
                        <div>
                            <div class="p-5">
                                <div class="flow-root ...">
                                    <strong>Asignaturas en la que se requiere formación o actualización: </strong>
                                    <v-divider></v-divider>
                                    <span>{{props.deteccion.asignaturaFA}}</span>
                                </div>
                                <div class="flow-root ... pt-7">
                                    <strong>Contenidos temáticos en que se requiere la formación o actualización: </strong>
                                    <v-divider></v-divider>
                                    <span>{{props.deteccion.contenidosTM}}</span>
                                </div>
                                <div class="flow-root ... pt-7">
                                    <strong>Número de profesores(as) que la requieren: </strong>
                                    <span>{{props.deteccion.numeroProfesores}}</span>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Modalidad: </strong>
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
                                    <strong>Periodo en el que se requiere la formación o actualización (enero-junio o agosto diciembre): </strong>
                                    <template v-if="props.deteccion.periodo === 1">
                                        <span>ENERO-JUNIO</span>
                                    </template>
                                    <template v-if="props.deteccion.periodo === 2  ">
                                        <span>AGOSTO-DICIEMBRE</span>
                                    </template>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Carrera a la que va dirigido: </strong>
                                    <span>{{props.deteccion.carrera.nameCarrera}}</span>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Facilitador(es): </strong>
                                    <div v-for="facilitador in props.deteccion.deteccion_facilitador">
                                        <span>{{facilitador.nombre}}  {{facilitador.apellidoPat}}  {{facilitador.apellidoMat}}</span>
                                    </div>
                                </div>
                                <template v-if="props.deteccion.facilitador_externo != null">
                                    <div class="flow-root ... pt-5">
                                        <strong>Facilitador externo: </strong>
                                        <span>{{props.deteccion.facilitador_externo}}</span>
                                    </div>
                                </template>
                                <div class="flow-root ... pt-5">
                                    <strong>Tipo de curso, taller, conferencias, etc: </strong>
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
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Tipo de solicitud: </strong>
                                    <template v-if="props.deteccion.tipo_FDoAP === 1">
                                        <span>FORMACIÓN DOCENTE</span>
                                    </template>
                                    <template v-if="props.deteccion.tipo_FDoAP === 2">
                                        <span>ACTUALIZACIÓN PROFESIONAL</span>
                                    </template>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Fechas en las que se realizara la actividad o evento: </strong>
                                    <span>Del {{formatFechaI}} al {{formatFechaF}}</span>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Horarios en las que se realizara la actividad o evento: </strong>
                                    <span>De {{props.deteccion.hora_I}} a {{props.deteccion.hora_F}}</span>
                                </div>
                                <div class="flow-root ... pt-5">
                                    <strong>Objetivo de la actividad o evento: </strong>
                                    <v-divider></v-divider>
                                    <span>{{props.deteccion.objetivoEvento}}</span>
                                </div>
                                <template v-if="props.deteccion.obs === 1">
                                    <div class="flow-root ... pt-5">
                                        <strong>Observaciones: </strong>
                                        <v-divider></v-divider>
                                        <span>{{props.deteccion.observaciones}}</span>
                                    </div>
                                </template>
                                <template v-if="props.deteccion.aceptado === 0">
                                    <form @submit.prevent="form.put(route('update.observaciones', props.deteccion.id))">
                                        <div class="flow-root ... pt-5">
                                            <strong>Añadir Observaciones: </strong>
                                            <!--                                <InputLabel for="observaciones" value="Añadir Observaciones" />-->
                                            <TextInput
                                                id="observaciones"
                                                type="text"
                                                class="mt-1 rounded w-full"
                                                v-model="form.observaciones"
                                                required
                                            />
                                            <PrimaryButton class="mt-4">Guardar.</PrimaryButton>

                                        </div>
                                    </form>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
