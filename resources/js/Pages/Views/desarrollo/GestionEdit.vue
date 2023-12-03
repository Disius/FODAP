<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCarrera from "@/Pages/Views/desarrollo/tablas/TablaCarrera.vue";
import NavLink from "@/Components/NavLink.vue";
import {router, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref} from "vue";
import TablaDepartamento from "@/Pages/Views/desarrollo/tablas/TablaDepartamento.vue";
import TablaLugares from "@/Pages/Views/desarrollo/tablas/TablaLugares.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TablaUsuariosCoordinacion from "@/Pages/Views/desarrollo/tablas/TablaUsuariosCoordinacion.vue";
import TablaUsuariosDocente from "@/Pages/Views/desarrollo/tablas/TablaUsuariosDocente.vue";
import TablaUsuariosAcademicos from "@/Pages/Views/desarrollo/tablas/TablaUsuariosAcademicos.vue";
import FormSubdireccion from "@/Pages/Views/dialogs/DialogSubdireccion.vue";
import TablaSub from "@/Pages/Views/desarrollo/tablas/TablaSub.vue";
import TablaDirector from "@/Pages/Views/desarrollo/tablas/TablaDirector.vue";
import DialogDirector from "@/Pages/Views/dialogs/DialogDirector.vue";


const search = ref("");
const dialogSub = ref(false);
const dialogDirector = ref(false);
const snackbar = ref(false);
const snack_success_cvu = ref(false);
const snack_error = ref(false);

const props = defineProps({
    docente: Array,
    carrera: Array,
    departamento: Array,
    auth: Object,
    lugar: Array,
    users: Array,
    sub: Array,
    fechas: Object,
    errors: Object,
    director: Array,
    instituto: Array,
});

const form = useForm({
    fecha_Inicio: "",
    fecha_Final: "",
});

const form_file = useForm({
    file: null,
});
const form_file_acta_img = useForm({
    file: null,
});
const form_file_constancia_img = useForm({
    file: null,
});
const form_file_constancia_img_2 = useForm({
    file: null,
});

function submit(){
    form.post(route('config.dates'), {
        onSuccess: () => {
            form.reset()
        },
        onError: () => {
            snackbar.value = true
        }
    });
}

const upload_cvu = () => {
    form_file.post(route('subir.cvu'), {
        forceFormData: true,
        onSuccess: () => {
            form_file.reset()
            snack_success_cvu.value = true
        },
        onError: () => {
            snack_error.value = true
        }
    })
}
const upload_acta = () => {
    form_file_acta_img.post(route('subir.actacalificaciones'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_acta_img.reset()
            snack_success_cvu.value = true
        },
        onError: () => {
            snack_error.value = true
        }
    })
}
const upload_constancia = () => {
    form_file_constancia_img.post(route('subir.constancia'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_constancia_img.reset()
            snack_success_cvu.value = true
        },
        onError: () => {
            snack_error.value = true
        }
    })
}
const upload_constancia_2 = () => {
    form_file_constancia_img_2.post(route('subir.constancia.2'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_constancia_img_2.reset()
            snack_success_cvu.value = true
        },
        onError: () => {
            snack_error.value = true
        }
    })
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
                    <h2 class="text-lg font-medium text-gray-900">Establecer fechas para la captura de Deteccion de Necesidades</h2>
                        <v-row dense justify="center" class="pa-6">
                            <v-col dense align="center" cols="6">
                                <v-alert color="info" icon="$info">
                                    <template v-if="props.fechas !== null">
                                        <div class="">
                                            <strong class="mr-3">Ultimas fechas establecidas: </strong>
                                            <div class="flex justify-center">
                                                <p>{{props.fechas.fecha_inicio}}</p>
                                                <p class="ml-5">al</p>
                                                <p class="ml-4">{{props.fechas.fecha_final}}</p>
                                            </div>
                                        </div>
                                    </template>
                                </v-alert>
                            </v-col>
                        </v-row>
                </header>
                    <v-row dense justify="center">
                        <form @submit.prevent="submit">
                            <v-col cols="12">
                                <InputLabel for="inicio" value="Inicia: "></InputLabel>
                                <v-text-field type="date" v-model="form.fecha_Inicio"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <InputLabel class="text-lg" for="termino" value="Termina: "></InputLabel>
                                <v-text-field type="date" v-model="form.fecha_Final"></v-text-field>
                            </v-col>
                            <v-col cols="12" align="end">
                                <primary-button>Guardar</primary-button>
                            </v-col>
                        </form>
                    </v-row>
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
                    <h2 class="text-xl font-medium text-gray-900 mb-8">Nombre de la Institución, del Director y de la Subdirección Académica</h2>
                </header>
                <tabla-sub :sub="props.sub" :modelValue="dialogSub" @update:modelValue="dialogSub = $event"></tabla-sub>
                <form-subdireccion :sub="props.sub" v-model="dialogSub" @update:modelValue="dialogSub = $event"></form-subdireccion>
                <template v-if="props.sub.length < 0">
                    <div class="flex justify-end mt-8 mr-12 items-center">
                        <primary-button @click="dialogSub = true">Crear/Guardar</primary-button>
                    </div>
                </template>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <tabla-director :director="props.director" :modelValue="dialogDirector" @update:modelValue="dialogDirector = $event"></tabla-director>
                <dialog-director :director="props.director" v-model="dialogDirector" @update:modelValue="dialogDirector = $event"></dialog-director>
                <template v-if="props.director.length < 0">
                    <div class="flex justify-end mt-8 mr-12 items-center">
                        <primary-button @click="dialogDirector = true">Crear/Guardar</primary-button>
                    </div>
                </template>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-xl font-medium text-gray-900 mb-8">Documentos</h2>
                </header>

                <div class="mt-15 mt-16">
                    <strong class="text-lg text-gray-600">
                        Subir CVU editable.
                    </strong>
                </div>

                <form @submit.prevent="upload_cvu">
                    <div class="grid grid-cols-1">
                        <div class="flex justify-center">
                            <v-file-input label="" variant="solo" @input="form_file.file = $event.target.files[0]"></v-file-input>
                            <div class="flex justify-end mt-2 ml-5 w-11">
                                <v-btn type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                            </div>
                        </div>
                    </div>
                </form>
                <v-snackbar
                    v-model="snack_success_cvu"
                    vertical
                    color="success"
                >
                    <div class="text-subtitle-1 pb-2"></div>

                    <p>CVU subido con exito</p>

                    <template v-slot:actions>
                        <v-btn
                            variant="text"
                            @click="snack_success_cvu = false"
                        >
                            Cerrar
                        </v-btn>
                    </template>
                </v-snackbar>

                <header>
                    <h2 class="text-xl font-medium text-gray-900 mb-8 mt-8">Membretado de documentos</h2>
                </header>
                <div class="mt-3">
                    <strong class="text-lg text-gray-600">
                        Subir membretado.
                    </strong>
                </div>
                <form @submit.prevent="upload_acta">
                    <div class="grid grid-cols-1">
                        <div class="flex justify-center">
                            <v-file-input label="Acta Calificaciones" variant="solo" @input="form_file_acta_img.file = $event.target.files[0]"></v-file-input>
                            <div class="flex justify-end mt-2 ml-5 w-11">
                                <v-btn type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                            </div>
                        </div>
                    </div>
                </form>
                <v-snackbar
                    v-model="snack_success_cvu"
                    vertical
                    color="success"
                >
                    <div class="text-subtitle-1 pb-2"></div>

                    <p>Membretado subido con exito</p>

                    <template v-slot:actions>
                        <v-btn
                            variant="text"
                            @click="snack_success_cvu = false"
                        >
                            Cerrar
                        </v-btn>
                    </template>
                </v-snackbar>
                <div class="flex justify-start ml-10 mb-2">
                    <v-tooltip location="right">
                        <template v-slot:activator="{ props }">
                            <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                <v-icon>
                                    mdi-help
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>En el caso de las constancias deben agregarse el membretado y la imagen.</span>
                    </v-tooltip>
                </div>
                <form @submit.prevent="upload_constancia">
                    <div class="grid grid-cols-1">
                        <div class="flex justify-center">
                            <v-file-input label="Constancia" variant="solo" @input="form_file_constancia_img.file = $event.target.files[0]"></v-file-input>
                            <div class="flex justify-end mt-2 ml-5 w-11">
                                <v-btn type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                            </div>
                        </div>
                    </div>
                </form>
                <form @submit.prevent="upload_constancia_2">
                    <div class="grid grid-cols-1">
                        <div class="flex justify-center">
                            <v-file-input label="Constancia Imagen 2" variant="solo" @input="form_file_constancia_img_2.file = $event.target.files[0]"></v-file-input>
                            <div class="flex justify-end mt-2 ml-5 w-11">
                                <v-btn type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <v-snackbar
            v-model="snack_error"
            vertical
            color="error"
        >
            <div class="text-subtitle-1 pb-2"></div>

            <p>Error. No es posible generar el recurso</p>

            <template v-slot:actions>
                <v-btn
                    variant="text"
                    @click="snack_error = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
