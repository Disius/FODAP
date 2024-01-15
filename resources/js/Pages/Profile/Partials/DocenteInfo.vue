<script setup>

import { computed, onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const user = computed(() => usePage().props.auth.user);
const alert = ref(true)
const snackbar = ref(false);
const timeout = ref(0)
const message = ref("");
const color = ref("")

const CURPValidator = [
    value => {
        if (value?.length <= 18 && /^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/.test(value)) return true

        return "La CURP no es correcta"
    }
];
const RFCValidator = [
    value => {
        if (value?.length <= 13 && /^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$/.test(value)) return true

        return "El RFC es incorrecto"
    }
];
const phone_number_rules = [
    value => {
        if (value?.length <= 10 || value?.length <= 10) return true

        return "Error en la logintud del número"
    }
];

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
    docente: Object,
    carrera: Array,
    departamento: Array,
    tipo_plaza: Array,
    puesto: Array,
    posgrado: Array,
    auth: Object
});
const form = useForm({
    id: user.value.id,
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

function submit() {
    if (!props.docente) {
        form.post(route('docente.create'), {
            onSuccess: () => {
                snackSuccessActivator()
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    } else {
        form.put(route('update.docente', props.docente.id), {
            onSuccess: () => {
                snackSuccessActivator()
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    }
}
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

// console.log(props.auth.role)
onMounted(() => {
    if (!props.docente) {
        return form
    } else {
        props.docente.departamento_id !== null ? form.departamento_id = user.value.departamento_id : form.departamento_id
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
    }


});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información personal</h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualizar tu información personal
            </p>
        </header>
            <div class="flex justify-center">
                <v-alert type="info" title="Atención"
                         text='Nombres como apellidos deben comenzar con MAYÚSCULAS y seguido de MINUSCULAS.' variant="tonal"
                         closable
                         :model-value="alert"></v-alert>
            </div>
            <template v-if="props.auth.role === 4">
                <div class="flex justify-center mt-3">
                    <v-alert type="warning" title="IMPORTANTE"
                             text='Colocar RFC y CURP en caso de estar dado de alta en el sistema' variant="tonal"
                             :model-value="alert"
                             closable
                    ></v-alert>
                </div>
            </template>
        <form class="mt-6 space-y-6" @submit.prevent="submit">
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
            <template v-if="props.auth.role === 4">
                <div>
                    <InputLabel for="curp" value="CURP" />

                    <!-- <TextInput
                        id="CURP"
                        type="text"
                        class="mt-1 rounded w-full"
                        v-model="form.curp"
                        required
                    /> -->
                    <v-text-field v-model="form.curp" :rules="CURPValidator" required>

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
                    <v-text-field v-model="form.rfc" :rules="RFCValidator" required>
                    </v-text-field>

                    <InputError class="mt-2" />
                </div>
                <div>
                    <InputLabel for="sexo" value="Sexo" />

                    <v-select variant="solo" :items="sex" item-title="text" item-value="value" v-model="form.sexo">

                    </v-select>
                </div>
            </template>
            <div>
                <div class="grid grid-cols-2">
                    <div class="flex justify-start">
                        <InputLabel for="carrera_adscrito" value="Licenciatura en la que imparte" />
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

                <template v-if="props.auth.role !== 4">
                    <v-select variant="solo" :items="props.carrera" item-value="id" item-title="nameCarrera"
                              v-model="form.carrera_id" disabled>

                    </v-select>
                </template>
                <template v-else>
                    <v-select variant="solo" :items="props.carrera" item-value="id" item-title="nameCarrera"
                              v-model="form.carrera_id" >

                    </v-select>
                </template>

                <InputError class="mt-2" />
            </div>
            <div>
                <InputLabel for="departamento_adscrito" value="Departamento adscrito" />

                <template v-if="props.auth.role !== 4">
                    <v-select variant="solo" :items="props.departamento" item-value="id" item-title="nameDepartamento"
                              v-model="form.departamento_id" disabled>

                    </v-select>
                </template>
                <template v-else>
                    <v-select variant="solo" :items="props.departamento" item-value="id" item-title="nameDepartamento"
                              v-model="form.departamento_id">

                    </v-select>
                </template>

                <InputError class="mt-2" />
            </div>
            <template v-if="props.auth.role === 4">
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

                    <TextInput id="Licenciatura" type="text" class="mt-1 rounded w-full" v-model="form.licenciatura" required />

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
                    <v-text-field v-model="form.telefono" required :rules="phone_number_rules" @input="formatearTelefono" ></v-text-field>
                    <v-text-field v-model="numeroTelefonoFormateado" ></v-text-field>
                    <!-- phone_number_rules -->
                    <InputError class="mt-2" />
                </div>
            </template>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
            <CustomSnackBar v-model="snackbar" :message="message" :color="color" :timeout="timeout" @update:modelValue="snackbar = $event"></CustomSnackBar>
        </form>
    </section>
</template>

<style scoped></style>
