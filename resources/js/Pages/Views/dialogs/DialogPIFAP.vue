<script setup>

import {computed, ref} from "vue";
import {saveAs} from "save-as";
import {cursoStore} from "@/store/cursos.js";
import {jsPDF} from "jspdf";

const store = cursoStore();
const errorHandle = ref("");
const alert = ref(false);


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
    const maxYears = new Date().getFullYear();
    const minYears = maxYears - 6;
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
    axios.get(route('pdf.pifdap'), {
        params: {
            periodo: form.value.periodo,
            anio: form.value.anio
        }
    }).then(res => {
        if (res.data.mensaje){
            alert.value = true
            errorHandle.value = res.data.mensaje
        }else {
            store.getCursos(res.data.cursos)
            generatePDF()
            // const url = '/storage/PIFDAP.pdf';
            // const link = document.createElement('a');
            // link.href = url;
            // link.setAttribute('download', 'PIFDAP.pdf');
            // document.body.appendChild(link);
            // link.click();
        }
    }).catch(error => {
        console.log(error)
    })



    const generatePDF = () => {
        const doc = new jsPDF('l', 'cm', 'a4')

        let img2 = document.createElement('img')
        img2.src = '/storage/img/logo.jpg';

        const totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++){
            let x = doc.internal.pageSize.getWidth()
            let y = doc.internal.pageSize.getHeight()
            // Add header
            doc.setFontSize(12);
            doc.setFont("Arial", 'bold')
            doc.addImage(img2, 'JPG', x - 25 , y - 17, 2.3, 2.3,)
            doc.text("PROGRAMA INSTITUCIONAL DE FORMACIÓN DOCENTE", x-10, y-12, {align:"center"});
            doc.text("INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ", x-10, y-10, {align:"center"});
            doc.text(`Periodo ${store.anio_realizacion}`, x-10, y-8, {align:"center"});
        }

        window.open(doc.output('bloburl', {
            filename: 'deteccion.pdf'
        }))

    }
}
</script>

<template>
    <v-dialog width="auto" persistent v-model="props.modelValue">
        <form @submit.prevent="submit">
            <v-card elevation="3" width="500" height="400">
                <v-card-title>Ingresar los datos para generar PDF</v-card-title>
                <v-card-text>
                    <div class="pb-2">
                        <v-alert
                            v-model="alert"
                            closable
                            close-label="Cerrar"
                            color="error"
                            icon="$error"
                            title="Error"
                        >
                            {{errorHandle}}
                        </v-alert>
                    </div>
                    <label for="anio" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Año: </label>
                    <div class="pt-5">
                        <v-select v-model="form.anio" :items="fullYears" item-title="name" item-value="id"></v-select>
                    </div>
                    <label for="periodo" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Periodo: </label>
                    <div class="pt-5">
                        <v-select v-model="form.periodo" :items="periodos" item-title="name" item-value="id"></v-select>
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
</template>

<style scoped>

</style>
