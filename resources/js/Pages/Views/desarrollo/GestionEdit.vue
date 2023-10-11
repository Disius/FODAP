<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCarrera from "@/Pages/Views/desarrollo/tablas/TablaCarrera.vue";
import NavLink from "@/Components/NavLink.vue";
import {router, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref} from "vue";
import FormCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import CreateCarrera from "@/Pages/Views/desarrollo/forms/CreateCarrera.vue";
import TablaDepartamento from "@/Pages/Views/desarrollo/tablas/TablaDepartamento.vue";
import TablaLugares from "@/Pages/Views/desarrollo/tablas/TablaLugares.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TablaUsuarios from "@/Pages/Views/desarrollo/tablas/TablaUsuariosAcademicos.vue";
import TablaUsuariosCoordinacion from "@/Pages/Views/desarrollo/tablas/TablaUsuariosCoordinacion.vue";
import TablaUsuariosDocente from "@/Pages/Views/desarrollo/tablas/TablaUsuariosDocente.vue";
import TablaUsuariosAcademicos from "@/Pages/Views/desarrollo/tablas/TablaUsuariosAcademicos.vue";
import FormSubdireccion from "@/Pages/Views/dialogs/DialogSubdireccion.vue";
import TablaSub from "@/Pages/Views/desarrollo/tablas/TablaSub.vue";


const search = ref("");
const dialogSub = ref(false);
const form = useForm({
    fecha_I: "",
    fecha_F: "",
});

const props = defineProps({
    docente: {
        type: Array
    },
    carrera: {
        type: Array
    },
    departamento: {
        type: Array,
    },
    auth: Object,
    lugar: Array,
    users: Array,
    sub: Array,
    fechas: Object,
});

function submit(){
    form.post(route('config.dates'), {
        onSuccess: () => {
            form.reset()
        },
    });
}


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
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-16 pt-16">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Establecer fechas para la captura de deteccion de necesidades</h2>
                    <template v-if="props.fechas !== null">
                        <div class="flex justify-center mt-4">
                            <strong class="mr-3">Ultima fecha establecida: </strong>
                            <p>{{props.fechas.fecha_inicio}}</p>
                            <p class="ml-5">al</p>
                            <p class="ml-4">{{props.fechas.fecha_final}}</p>
                        </div>
                    </template>
                </header>

                <form @submit.prevent="submit">
                    <div class="flex justify-center mr-5 items-center">
                        <InputLabel for="inicio" value="Inicia: "></InputLabel>
                        <v-text-field type="date" v-model="form.fecha_I"></v-text-field>
                    </div>
                    <div class="flex justify-center items-center">
                        <InputLabel class="text-lg" for="termino" value="Termina: "></InputLabel>
                        <v-text-field type="date" v-model="form.fecha_F"></v-text-field>
                    </div>
                    <div class="flex justify-center items-end mr-8">
                        <primary-button>Guardar</primary-button>
                    </div>
                </form>
            </div>
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Areas academicas</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Actualizar o añadir
                    </p>
                </header>
                <TablaCarrera :carrera="props.carrera"></TablaCarrera>
                <div class="flex justify-end mr-12 mt-12 h-6 items-center gap-4">
                    <NavLink :href="route('create.carrera')">
                        <PrimaryButton>Crear una nueva área</PrimaryButton>
                    </NavLink>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Departamentos</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Actualizar o añadir departamentos
                    </p>
                </header>
                <TablaDepartamento :departamento="props.departamento"></TablaDepartamento>
                <div class="flex justify-end mr-12 mt-12 h-6 items-center gap-4">
                    <NavLink :href="route('create.departamento')">
                        <PrimaryButton>Crear un departamento</PrimaryButton>
                    </NavLink>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Lugar</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Lugares donde se llevan a cabo cursos y actividades.
                    </p>
                </header>
                <TablaLugares :lugar="props.lugar"></TablaLugares>
                <div class="flex justify-end mt-8 mr-12 items-center">
                    <NavLink :href="route('create.lugar')" as="button">
                        <primary-button>Crear</primary-button>
                    </NavLink>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-xl font-medium text-gray-900 mb-8">Usuarios</h2>

                    <strong class="mt-1 text-lg text-gray-600">
                        Jefes de departamento.
                    </strong>
                </header>
                <TablaUsuariosAcademicos :users="props.users"></TablaUsuariosAcademicos>

                <div class="mt-15 mb-4">
                    <strong class="text-lg text-gray-600">
                        Coordinación de formación docente y actualización profesional.
                    </strong>
                </div>
                <TablaUsuariosCoordinacion :users="props.users"></TablaUsuariosCoordinacion>

                <div class="grid grid-cols-2 mt-9">
                    <div class="flex justify-start">
                        <strong class="text-lg text-gray-600 mb-3">
                            Docentes.
                        </strong>
                    </div>
<!--                    <div class="flex justify-center">-->
<!--                        <v-text-field label="Buscar" variant="solo" v-model="search"></v-text-field>-->
<!--                    </div>-->
                </div>
                <TablaUsuariosDocente :auth="props.auth" :users="props.users"></TablaUsuariosDocente>
                <div class="flex justify-end mt-8 mr-12 items-center">
<!--&lt;!&ndash;                    <NavLink :href="route('create.lugar')" as="button">&ndash;&gt;-->
<!--                    <primary-button>Crear</primary-button>-->
<!--&lt;!&ndash;                    </NavLink>&ndash;&gt;-->
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-xl font-medium text-gray-900 mb-8">Subdirección Académica</h2>
                </header>
                <tabla-sub :sub="props.sub" :modelValue="dialogSub" @update:modelValue="dialogSub = $event"></tabla-sub>
                <form-subdireccion :sub="props.sub" v-model="dialogSub" @update:modelValue="dialogSub = $event"></form-subdireccion>
                <template v-if="props.sub.length < 0">
                    <div class="flex justify-end mt-8 mr-12 items-center">
                        <primary-button @click="dialogSub = true">Crear</primary-button>
                    </div>
                </template>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
