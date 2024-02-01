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
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import NombreInstitutoTable from "@/Pages/Views/desarrollo/tablas/NombreInstitutoTable.vue";
import DialogNombreInstituto from "@/Pages/Views/dialogs/DialogNombreInstituto.vue";


const search = ref("");
const dialogSub = ref(false);
const dialogDirector = ref(false);
const snackbar = ref(false);
const message = ref("")
const color = ref()
const timeout = ref(0)
const dialogInstituto = ref(false);

const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
};
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
const img_logo_ittg = useForm({
    file: null,
});
const img_logo_tecnm = useForm({
    file: null,
});
const img_logo_educacion = useForm({
    file: null,
});

function submit(){
    form.post(route('config.dates'), {
        onSuccess: () => {
            form.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    });
}

const upload_cvu = () => {
    form_file.post(route('subir.cvu'), {
        forceFormData: true,
        onSuccess: () => {
            form_file.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_acta = () => {
    form_file_acta_img.post(route('subir.actacalificaciones'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_acta_img.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_constancia = () => {
    form_file_constancia_img.post(route('subir.constancia'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_constancia_img.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_constancia_2 = () => {
    form_file_constancia_img_2.post(route('subir.constancia.2'), {
        forceFormData: true,
        onSuccess: () => {
            form_file_constancia_img_2.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_logotec = () => {
    img_logo_ittg.post(route('subir.logoTec'), {
        forceFormData: true,
        onSuccess: () => {
            img_logo_ittg.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_tecnm = () => {
    img_logo_tecnm.post(route('subir.logoTecnm'), {
        forceFormData: true,
        onSuccess: () => {
            img_logo_tecnm.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const upload_educacion = () => {
    img_logo_educacion.post(route('subir.logoEducacion'), {
        forceFormData: true,
        onSuccess: () => {
            img_logo_educacion.reset()
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
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
                    <h2 class="text-lg font-medium text-gray-900">Aréas académicas</h2>

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
                <div class="flex justify-center">
                    <v-text-field label="Buscar" variant="solo" v-model="search" clearable></v-text-field>
                </div>
                <TablaUsuariosAcademicos :users="props.users" :search="search"></TablaUsuariosAcademicos>

                <div class="mt-15 mb-4">
                    <strong class="text-lg text-gray-600">
                        Coordinación de formación docente y actualización profesional.
                    </strong>
                </div>
                <TablaUsuariosCoordinacion :users="props.users"></TablaUsuariosCoordinacion>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-xl font-medium text-gray-900 mb-8 text-center">Nombre de la Institución, del Director y de la Subdirección Académica</h2>
                </header>
                <div class="grid grid-cols-2">
                    <div class="flex justify-center">
                        <tabla-sub :sub="props.sub" :modelValue="dialogSub" @update:modelValue="dialogSub = $event"></tabla-sub>
                        <form-subdireccion :sub="props.sub" v-model="dialogSub" @update:modelValue="dialogSub = $event"></form-subdireccion>
                        <template v-if="props.sub.length < 0">
                            <div class="flex justify-end mt-8 mr-12 items-center">
                                <primary-button @click="dialogSub = true">Crear/Guardar</primary-button>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-center">
                        <tabla-director :director="props.director" :modelValue="dialogDirector" @update:modelValue="dialogDirector = $event"></tabla-director>
                        <dialog-director :director="props.director" v-model="dialogDirector" @update:modelValue="dialogDirector = $event"></dialog-director>
                        <template v-if="props.director.length < 0">
                            <div class="flex justify-end mt-8 mr-12 items-center">
                                <primary-button @click="dialogDirector = true">Crear/Guardar</primary-button>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="grid grid-cols-2">
                    <div class="flex justify-center">
                        <NombreInstitutoTable :instituto="props.instituto" :modelValue="dialogInstituto" @update:modelValue="dialogInstituto = $event"></NombreInstitutoTable>
                        <DialogNombreInstituto :instituto="props.instituto" v-model="dialogInstituto" @update:modelValue="dialogInstituto = $event"></DialogNombreInstituto>
                        <template v-if="props.instituto.length < 0">
                            <div class="flex justify-end mt-8 mr-12 items-center">
                                <primary-button @click="dialogDirector = true">Crear/Guardar</primary-button>
                            </div>
                        </template>
                    </div>
                </div>
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
                            <v-file-input label="Constancia imagen del reverso" variant="solo" @input="form_file_constancia_img_2.file = $event.target.files[0]"></v-file-input>
                            <div class="flex justify-end mt-2 ml-5 w-11">
                                <v-btn type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Imagenes del sistema</h2>
                    <v-row dense justify="center" class="pa-6">
                        <v-col dense align="center" cols="6">
                            <div class="d-flex justify-start mb-5">
                                <v-tooltip location="right">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon color="blue-darken-1" v-bind="props" size="normal">
                                            <v-icon>
                                                mdi-help
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Los archivos deben ser JPG</span>
                                </v-tooltip>
                            </div>
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="grid grid-cols-1">
                                    <div class="flex justify-center">
                                        <v-file-input label="Ingresar logo del Instituto Tecnológico" variant="solo" @input="img_logo_ittg.file = $event.target.files[0]"></v-file-input>
                                        <div class="flex justify-end mt-2 ml-5 w-11">
                                            <v-btn @click="upload_logotec"  type="submit" color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="flex justify-center">
                                        <v-file-input label="Ingresar logo del Tecnm" variant="solo" @input="img_logo_tecnm.file = $event.target.files[0]"></v-file-input>
                                        <div class="flex justify-end mt-2 ml-5 w-11">
                                            <v-btn @click="upload_tecnm"  color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="flex justify-center">
                                        <v-file-input label="Ingresar logo de la SEP" variant="solo" @input="img_logo_educacion.file = $event.target.files[0]"></v-file-input>
                                        <div class="flex justify-end mt-2 ml-5 w-11">
                                            <v-btn @click="upload_educacion"  color="blue-darken-1" width="500" icon="mdi-content-save-check-outline"></v-btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </v-col>
                    </v-row>
                </header>
                <v-row dense justify="center">

                </v-row>
            </div>
        </div>

        <CustomSnackBar :message="message" :color="color" :timeout="timeout" v-model="snackbar" @update:modelValue="snackbar = $event"></CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
