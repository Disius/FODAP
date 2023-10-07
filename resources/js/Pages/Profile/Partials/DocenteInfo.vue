<script setup>

import { computed, onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const user = computed(() => usePage().props.auth.user);
const alert = ref(true)
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
        if (value?.length <= 12 || value?.length <= 12) return true

        return "Error en la logintud del número"
    }
];
const props = defineProps({
    docente: Object,
    carrera: Array,
    departamento: Array,
    tipo_plaza: Array,
    puesto: Array,
    posgrado: Array,
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
const sex = [{ value: 1, text: "M" }, { value: 2, text: "F" }];


function submit() {
    if (!props.docente) {
        form.post(route('docente.create'))
    } else {
        form.put(route('update.docente', props.docente.id))
    }
}


onMounted(() => {
    if (!props.docente) {
        return form
    } else {
        form.departamento_id = user.value.departamento_id
        form.nombre = props.docente.nombre
        form.apellidoPat = props.docente.apellidoPat
        form.apellidoMat = props.docente.apellidoMat
        form.curp = props.docente.curp
        form.rfc = props.docente.rfc
        form.telefono = props.docente.telefono
        props.docente.carrera_id !== null ? form.carrera_id = props.docente.carrera_id : form.carrera_id
        form.sexo = props.docente.sexo
        form.departamento_id = props.docente.departamento_id
        form.id_puesto = props.docente.id_puesto
        form.tipo_plaza = props.docente.tipo_plaza
        form.licenciatura = props.docente.licenciatura
        form.id_posgrado = props.docente.id_posgrado
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
                <v-text-field v-model="form.curp" :rules="CURPValidator">

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
                <v-text-field v-model="form.rfc" :rules="RFCValidator">
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
                <v-text-field v-model="form.telefono" required :rules="phone_number_rules"></v-text-field>
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
    </section>
</template>

<style scoped></style>
