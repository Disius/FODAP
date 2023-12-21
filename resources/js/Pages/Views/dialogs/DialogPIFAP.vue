<script setup>
import {computed, onMounted, ref} from "vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import Loading from "@/Components/Loading.vue";

const message = ref("")
const color = ref("")
const timeout = ref()
const snackbar = ref()
const loading = ref(false)

const props = defineProps({
    modelValue: Boolean,
});
const emit = defineEmits([
    'update:modelValue'
]);

const form = ref({
    anio: null,
    periodo: null
});

const fullYears = computed(() => {
    const maxYears = new Date().getFullYear() + 1;
    const minYears = maxYears - 7;
    const years = [];

    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});

const periodos = [
    {id: 1, name: "ENERO-JUNIO"},
    {id: 2, name: "AGOSTO-DICIEMBRE"}
];

function submit(){
    loading.value = true
    axios.get(route('pdf.pifdap'), {
        params: {
            periodo: form.value.periodo,
            anio: form.value.anio
        }
    }).then(res => {
        if (res.data.mensaje){
            message.value = res.data.mensaje
            color.value = 'error'
            timeout.value = 5000
            snackbar.value = true
            loading.value = false
            setTimeout(()=>{
                snackbar.value = false
            },timeout.value)
        }else {
            const url = '/storage/PIFDAP.pdf';
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'PIFDAP.pdf');
            document.body.appendChild(link);
            link.click();
            message.value = 'Documento generado con exito'
            color.value = 'success'
            timeout.value = 5000
            snackbar.value = true
            loading.value = false
            setTimeout(()=>{
                snackbar.value = false
            },timeout.value)
        }
    }).catch(error => {
        message.value = 'Error al generar el documento'
        color.value = 'error'
        timeout.value = 5000
        loading.value = false
        snackbar.value = true
        setTimeout(()=>{
            snackbar.value = false
        },timeout.value)
    })
}



onMounted(() => {

})
</script>

<template>
    <v-dialog width="auto" persistent v-model="props.modelValue">
        <form @submit.prevent="submit">
            <v-card elevation="3" width="500" height="500">
                <v-card-title>Ingresar los datos para generar PDF</v-card-title>
                <v-card-text>
                    <label for="anio" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Año: </label>
                    <div class="pt-5">
                        <v-select v-model="form.anio" :items="fullYears" item-title="name" item-value="id" variant="solo"></v-select>
                    </div>
                    <label for="periodo" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Periodo: </label>
                    <div class="pt-5">
                        <v-select v-model="form.periodo" :items="periodos" item-title="name" item-value="id" variant="solo"></v-select>
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
    <CustomSnackBar
    :color="color" :timeout="timeout" :message="message" v-model="snackbar" @update:modelValue="snackbar = $event"
    >

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

<style scoped>

</style>
