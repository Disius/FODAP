<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    departamento: {
        type: Array
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
const sex = [{ value: 1, text: "M" }, { value: 2, text: "F" }];
const phone_number_rules = [
    value => {
        if (value?.length <= 10 || value?.length <= 10) return true

        return "Error en la logintud del número"
    }
];
const snackbar = ref(false);
const emit = defineEmits([
    'update:modelValue',
    'docenteAdd'
])
const numeroTelefonoFormateado = ref('');
const formatearTelefono = () => {
    // Eliminar cualquier guión existente
    form.telefono = form.telefono.replace(/-/g, '');

    // Dividir el número de teléfono en segmentos y agregar guiones
    const segmento1 = form.telefono.slice(0, 3);
    const segmento2 = form.telefono.slice(3, 6);
    const segmento3 = form.telefono.slice(6, 10);

    // Crear el número de teléfono formateado
    numeroTelefonoFormateado.value = `${segmento1}-${segmento2}-${segmento3}`;
};
const submit = () => {
    emit('docenteAdd', form)
}
</script>

<template>
    <v-dialog
        v-model="props.modelValue"
        :scrim="false"
        transition="dialog-bottom-transition">
        <form class="mt-6 space-y-6" @submit.prevent="submit">
            <v-card>
                <v-toolbar
                    dark
                    color="primary"
                >
                    <v-btn
                        icon
                        dark
                        @click="emit('update:modelValue', false)"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Crear Docente</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>

                    </v-toolbar-items>
                </v-toolbar>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" >
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
                                    <span>No es necesario rellenar todos los campos</span>
                                </v-tooltip>
                            </p>
                        </header>
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
                                        <InputLabel for="carrera_adscrito" value="Licenciatura en la que imparte la mayoría de las asignaturas" />
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
                                <v-text-field v-model="form.telefono" :rules="phone_number_rules" @input="formatearTelefono" ></v-text-field>
                                <v-text-field v-model="numeroTelefonoFormateado"></v-text-field>
                                <!-- phone_number_rules -->
                                <InputError class="mt-2" />
                            </div>

                    </div>
                </div>
                <v-divider></v-divider>
                <div class="flex items-center gap-4 mr-15">
                    <v-btn type="submit" color="blue-darken-1" icon="mdi-content-save-all" size="x-large" class="floating-btn">

                    </v-btn>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                    </Transition>
                </div>
            </v-card>
        </form>
    </v-dialog>
</template>

<style scoped>
.floating-btn {
    position: fixed;
    bottom: 50px; /* Ajusta la posición vertical como desees */
    right: 200px; /* Ajusta la posición horizontal como desees */
    z-index: 1000; /* Ajusta el z-index según tus necesidades para asegurarte de que esté por encima de otros elementos. */
    width: 80px;
    height: 80px;
}
</style>
