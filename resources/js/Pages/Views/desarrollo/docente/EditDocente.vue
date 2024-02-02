<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import UpdatePasswordFormSelected from "@/Pages/Views/desarrollo/forms/UpdatePasswordFormSelected.vue";
import UpdateProfileInformationFormSelected
    from "@/Pages/Views/desarrollo/forms/UpdateProfileInformationFormSelected.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const props = defineProps({
    departamento: {
        type: Array
    },
    docente: {
        type: Object
    },
    tipo_plaza: {
        type: Array,
    },
    puesto: {
        type: Array
    },
    carrera: {
        type: Array,
    },
    auth: {
        type: Object
    },
    posgrado: {
        type: Array
    },
});
const alert = ref(true)
const form = useForm({
    id: null,
    rfc: "",
    curp: "",
    nombre: "",
    apellidoPat: "",
    apellidoMat: "",
    sexo: null,
    telefono: "",
    carrera_id: null,
    id_puesto: null,
    tipo_plaza: null,
    departamento_id: null,
    licenciatura: "",
    id_posgrado: null,
});
const sex = [{ value: 1, text: "MASCULINO" }, { value: 2, text: "FEMENINO" }];
const show_update_password = ref(false)
const message = ref()
const color = ref()
const timeout = ref()
const snackbar = ref()

const submit = () => {
    form.put(route('update.docentes', props.docente.id), {
        onSuccess: () => {
          suceess()
        },
        onError: () => {
            error_form()
        }
    })
}

const closeModal = () => {
    show_update_password.value = false;
};
function suceess(){
    message.value = "Actualizado con exito"
    color.value = "success"
    timeout.value = 2000;
    snackbar.value = true
    setTimeout(() => {
        snackbarSuccess.value = false;
    }, timeout.value);
}
function error_form() {
    message.value = "Error al actualizar este recurso"
    color.value = "error"
    timeout.value = 2000;
    snackbar.value = true
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
}

const formUser = useForm({
    email: "",
})
const submitUser = () => {
    formUser.post(route('editar.email', props.docente.usuario.id), {
        onSuccess: () => {
            suceess()
        },
        onError: () => {
            error_form()
        }
    })
}


onMounted(() => {
    if (!props.docente) {
        return form
    } else {
        props.docente.departamento_id !== null ? form.departamento_id = props.docente.departamento_id : form.departamento_id
        props.docente.nombre !== null ? form.nombre = props.docente.nombre : form.nombre
        props.docente.apellidoPat !== null ? form.apellidoPat = props.docente.apellidoPat : form.apellidoPat
        props.docente.apellidoMat !== null ? form.apellidoMat = props.docente.apellidoMat : form.apellidoMat
        props.docente.curp !== null ? form.curp = props.docente.curp : form.curp
        props.docente.rfc !== null ? form.rfc = props.docente.rfc : form.rfc
        props.docente.telefono !== null ? form.telefono = props.docente.telefono : form.telefono
        props.docente.carrera_id !== null ? form.carrera_id = props.docente.carrera_id : form.carrera_id
        props.docente.sexo !== null ? form.sexo = props.docente.sexo : form.sexo
        props.docente.departamento_id !== null ? form.departamento_id = props.docente.departamento_id : form.departamento_id
        props.docente.id_puesto !== null ? form.id_puesto = props.docente.id_puesto : form.id_puesto
        props.docente.tipo_plaza !== null ? form.tipo_plaza = props.docente.tipo_plaza : form.tipo_plaza
        props.docente.licenciatura !== null ? form.licenciatura = props.docente.licenciatura : form.licenciatura
        props.docente.id_posgrado !== null ? form.id_posgrado = props.docente.id_posgrado : form.id_posgrado
        props.docente.usuario.email !== null ? formUser.email = props.docente.usuario.email : formUser.email
        // if (props.docente.usuario !== null){
        //     props.docente.usuario.email = formUser.email
        // }else{
        //     console.log("Usuario registrado no existe")
        // }
    }
})
</script>

<template>
<AuthenticatedLayout>
    <template #header>
        <div class="flex justify-start mb-5">
            <NavLink :href="route('index.docentes')" as="button">
                <div class="flex justify-start">
                    <v-btn icon>
                        <v-icon>mdi-arrow-left</v-icon>
                    </v-btn>
                </div>
            </NavLink>
        </div>
        <h2 class="text-lg font-medium text-gray-900">Crear Docente</h2>
    </template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Información personal del docente</h2>

                <p class="mt-1 text-sm text-gray-600">
                        <v-tooltip location="right">
                            <template v-slot:activator="{ props }">
                                <v-btn icon color="blue-darken-1" v-bind="props" size="normal">
                                    <v-icon size="x-large">
                                        mdi-help
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>No es necesario en este momento rellenar todos los campos</span>
                        </v-tooltip>
                </p>
            </header>
<!--            <div v-if="props.docente.usuario">-->
                <div class="mt-5">
                    <form @submit.prevent="submitUser">
                        <div class="grid grid-cols-2">
                            <div>
                                <InputLabel for="email" value="Correo Institucional" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="formUser.email"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="formUser.errors.email" />
                            </div>
                            <template v-if="props.docente.usuario">
                                <div class="flex justify-center">
                                    <primary-button type="submit">Actualizar email</primary-button>
                                </div>
                            </template>
                        </div>
                    </form>
                </div>
            <div class="mt-5">
                <div>
                    <secondary-button @click="show_update_password = true">Actualizar contraseña</secondary-button>
                    <Modal :show="show_update_password" @close="closeModal">
                        <div class="grid grid-rows-1">
                            <div class="flex justify-start relative ma-5">
                                <secondary-button @click="show_update_password = false"><v-icon>mdi-close</v-icon></secondary-button>
                            </div>
                        </div>
                        <div class="container mx-auto">
                            <div class="flex justify-center items-center mb-5">
                                <UpdatePasswordFormSelected :user="props.docente.usuario"></UpdatePasswordFormSelected>
                            </div>
                        </div>
                    </Modal>
                </div>
            </div>
<!--            </div>-->
            <form class="mt-6 space-y-6" @submit.prevent="submit">
                <div class="flex justify-center">
                    <v-alert type="info" title="Atención"
                             text='Nombres como apellidos deben comenzar con MAYÚSCULAS y seguido de MINUSCULAS' variant="tonal"
                             :model-value="alert"></v-alert>
                </div>
                <div>
                    <InputLabel for="nombre" value="Nombre" />

                    <TextInput id="nombre" type="text" class="mt-1 rounded w-full" v-model="form.nombre" required />

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="apellido_pat" value="Apellido Paterno" />

                    <TextInput id="apellido_pat" type="text" class="mt-1 rounded w-full" v-model="form.apellidoPat" required />

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="apellido_mat" value="Apellido Materno" />

                    <TextInput id="apellido_mat" type="text" class="mt-1 rounded w-full" v-model="form.apellidoMat" required />

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="curp" value="CURP" />

                    <!-- <TextInput
                        id="CURP"
                        type="text"
                        class="mt-1 rounded w-full"
                        v-model="form.curp"
                        required
                    /> -->
                    <v-text-field v-model="form.curp">

                    </v-text-field>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="rfc" value="RFC" />

                    <!-- <TextInput
                        id="RFC"
                        type="text"
                        class="mt-1 rounded w-full"
                        v-model="form.rfc"
                        required
                    /> -->
                    <v-text-field v-model="form.rfc">
                    </v-text-field>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="sexo" value="Sexo" />

                    <v-select variant="solo" :items="sex" item-title="text" item-value="value" v-model="form.sexo">

                    </v-select>
                </div>
                <div>
                    <div class="grid grid-cols-2">
                        <div class="flex justify-start">
                            <InputLabel for="carrera_adscrito" value="Carrera adscrito" />
                        </div>
                        <div class="flex justify-center mb-3">
                            <v-tooltip location="right">
                                <template v-slot:activator="{ props }">
                                    <v-btn icon v-bind="props" size="normal" color="blue-darken-1">
                                        <v-icon>
                                            mdi-help
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <span>Es la carrera en la que se tiene mas horas asginadas frente al grupo</span>
                            </v-tooltip>
                        </div>
                    </div>

                    <v-select variant="solo" :items="props.carrera" item-value="id" item-title="nameCarrera"
                              v-model="form.carrera_id">

                    </v-select>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="departamento_adscrito" value="Departamento adscrito" />

                    <v-select variant="solo" :items="props.departamento" item-value="id" item-title="nameDepartamento"
                              v-model="form.departamento_id">

                    </v-select>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="puesto" value="Puesto" />

                    <v-select variant="solo" :items="props.puesto" item-value="id" item-title="nombre" v-model="form.id_puesto">

                    </v-select>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="plaza" value="Plaza" />

                    <v-select variant="solo" :items="props.tipo_plaza" item-value="id" item-title="nombre"
                              v-model="form.tipo_plaza">

                    </v-select>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <v-alert v-model="alert" border="start" variant="tonal" closable close-label="Alerta" color="info"
                             title="Alerta" class="mt-4">
                        La licenciatura debe iniciar por mayusculas
                    </v-alert>
                    <InputLabel for="licenciatura" value="Licenciatura" class="mt-2" />

                    <TextInput id="Licenciatura" type="text" class="mt-1 rounded w-full" v-model="form.licenciatura"  />

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="posgrado" value="Ultimo grado de estudios" />

                    <v-select variant="solo" :items="props.posgrado" item-title="nombre" item-value="id"
                              v-model="form.id_posgrado"></v-select>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="telefono" value="Telefono celular" />

                    <!-- <TextInput id="telefono" type="text" class="mt-1 rounded w-full" v-model="form.telefono" required /> -->
                    <v-text-field v-model="form.telefono" ></v-text-field>
                    <!-- phone_number_rules -->
                    <InputError class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </div>
    <CustomSnackBar :message="message" :color="color" @update:modelValue="snackbar = $event" v-model="snackbar"></CustomSnackBar>
</AuthenticatedLayout>
</template>

<style scoped>

</style>
