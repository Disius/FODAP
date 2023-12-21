<script setup>
import { computed, onMounted, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import Loading from "@/Components/Loading.vue";

const snackSuccess = ref(false);
const timeout = ref(0)
const message = ref("")
const color = ref("")
const loading = ref(false)

const props = defineProps({
    modelValue: Boolean,
    carreras: Array,
});
const emit = defineEmits([
    'update:modelValue'
]);

const form = useForm({
    periodo: null,
    carrera: null,
    anio: null
});
const periodos = [
    { id: 1, name: "ENERO-JUNIO" },
    { id: 2, name: "AGOSTO-DICIEMBRE" }
];
const fullYears = computed(() => {
    const maxYears = new Date().getFullYear() + 1;
    const minYears = maxYears - 7;
    const years = [];
    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});


function submit() {
    loading.value = true
    axios.get('/pdf/deteccion', {
        params: {
            anio: form.anio,
            carrera: form.carrera,
            periodo: form.periodo,
        }
    }).then(res => {
        // cursos.value = res.data.cursos
        if (res.data.mensaje) {
            message.value = res.data.mensaje
            color.value = 'error'
            timeout.value = 5000
            snackSuccess.value = true
        }
        else {
            const url = '/storage/Deteccion.pdf';
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'deteccion.pdf');
            document.body.appendChild(link);
            link.click();
            form.reset()
            message.value = 'Documento generado con exito'
            timeout.value = 5000
            color.value = 'success'
            snackSuccess.value = true
            loading.value = false
        }

    }).catch(error => {
        message.value = '¡Debe ingresar los datos para generar el documento!';
        color.value = 'error'
        timeout.value = 5000
        snackSuccess.value = true
        loading.value = false

    })

}


onMounted(() => {
    setTimeout(() => {
        snackSuccess.value = false
    }, timeout.value)
})

</script>

<template>
    <v-dialog width="auto" persistent v-model="props.modelValue">
        <form @submit.prevent="submit">
            <v-card elevation="3" width="500" height="500">
                <v-card-title>Ingresar los datos para generar PDF</v-card-title>
                <v-card-text>
                    <label for="carrera"
                        class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Carrera a
                        la que va dirigida: </label>
                    <div class="pt-5">
                        <v-select v-model="form.carrera" :items="props.carreras" item-title="nameCarrera"
                            item-value="id" variant="solo"></v-select>
                    </div>
                    <label for="periodo"
                        class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Periodo:
                    </label>
                    <div class="pt-5">
                        <v-select v-model="form.periodo" :items="periodos" item-title="name" item-value="id" variant="solo"></v-select>
                    </div>
                    <label for="anio"
                        class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Año:
                    </label>
                    <div class="pt-5">
                        <v-select v-model="form.anio" :items="fullYears" item-title="name" item-value="id" variant="solo"></v-select>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-row justify="end">
                        <v-col cols="4">
                            <v-btn color="error" @click="emit('update:modelValue', false)">
                                Cancelar
                            </v-btn>
                        </v-col>
                        <v-col cols="4">
                            <v-btn @click="submit" color="success" prepend-icon="mdi-file-pdf-box">
                                Generar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </form>
    </v-dialog>
    <CustomSnackBar :message="message" :color="color" :timeout="timeout" v-model="snackSuccess" @update:modelValue="snackSuccess = $event">

    </CustomSnackBar>
    <Loading v-model="loading" @update:loading="loading = $event">
        <v-fade-transition leave-absolute>
            <v-progress-circular
                v-if="loading"
                color="info"
                :size="64"
                :width="7"
                indeterminate
            ></v-progress-circular>
        </v-fade-transition>
    </Loading>
</template>

<style scoped></style>
