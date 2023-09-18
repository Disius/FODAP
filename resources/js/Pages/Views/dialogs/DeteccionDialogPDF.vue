<script setup>
import {computed, ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import axios from "axios";
import {cursoStore} from '@/store/cursos.js'
import {jsPDF} from "jspdf";
import {storeToRefs} from "pinia";
import autoTable from 'jspdf-autotable'

const store = cursoStore()
const { cursos } = storeToRefs(store)
const { getCursos } = store
const {course} = store

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
    {id: 1, name: "ENERO-JUNIO"},
    {id: 2, name: "AGOSTO-DICIEMBRE"}
];

const fullYears = computed(() => {
    const maxYears = new Date().getFullYear();
    const minYears = maxYears - 6;
    const years = [];

    for (let i = maxYears; i >= minYears; i--) {
        years.push(i)
    }

    return years
});


function submit(){
    axios.get('/pdf/deteccion', {
        params: {
            anio: form.anio,
            carrera: form.carrera,
            periodo: form.periodo,
        }
    }).then(res => {
        // cursos.value = res.data.cursos
        getCursos(res.data.cursos)
        pdfGenerate()
        form.reset()

    }).catch(error => {
        console.log(error)
    })

}

function pdfGenerate(){
    //imagenes
    let img = document.createElement('img')
    img.src = '/storage/img/ITTG.png';
    let img2 = document.createElement('img')
    img2.src = '/storage/img/logo.jpg';


        const doc = new jsPDF('p', 'cm');

        //logo y nombre de la institución
        doc.setFontSize(12);
        doc.setFont("Arial")
        doc.addImage(img2, 'JPG', 4, 1.1, 1.2, 1)
        doc.text("INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ", 5.7, 1.7);

        //segunda seccion, subdireccion, departamento
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text("Subdirección Académica", 8.8, 3.1)
        doc.text(`Departamento Académico: ${store.course.value[0].departamento.nameDepartamento}`, 5.9, 3.5)

        //tercera seccion
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text("DIAGNÓSTICO DE NECESIDADES DE", 7.8, 4.3)
        doc.text("FORMACIÓN DOCENTE Y ACTUALIZACIÓN PROFESIONAL", 6, 4.7)

        //cuarta seccion
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text(`PARA LAS(OS) PROFESORAS(ES) DE LA ACADEMIA DE: ${store.course.value[0].carrera.nameCarrera}`, 3.6, 5.8)
        doc.setFontSize(10)
        doc.setFont("Arial", 'normal')
        doc.text(`Fecha de realización del diagnóstico: `, 3.6, 6.3)

        //tablas
        doc.setFontSize(10)
        doc.setFont("Arial", 'normal')
        doc.text('Jefa (e) del Departamento Académico', 3.7, 6.9)

        autoTable(doc, {
            margin: {left: 2.5, right: 4},
            styles: {
                fontSize: 10,
                lineWidth: 0.01,
                lineColor: [0,0,0]
            },
            tableWidth: 14,
            theme: 'plain',
            columnStyles: { 0: { cellWidth: 8 }, 1: { cellWidth: 8} },
            startY: 7.0,
            startX: 3.5,
            head: [['Nombre', 'Firma']],
            body: [
                [[store.course.value[0].jefe.nombre_completo]],
                // ...
            ],
        })
        //save
        doc.save('deteccion.pdf')
}

</script>

<template>
    <v-dialog width="auto" persistent v-model="props.modelValue">
        <form @submit.prevent="submit">
            <v-card elevation="3" width="500" height="500">
                <v-card-title>Ingresar los datos para generar PDF</v-card-title>
                <v-card-text>
                    <label for="carrera" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Carrera a la que va dirigida: </label>
                    <div class="pt-5">
                        <v-select v-model="form.carrera" :items="props.carreras" item-title="nameCarrera" item-value="id"></v-select>
                    </div>
                    <label for="periodo" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Periodo: </label>
                    <div class="pt-5">
                        <v-select v-model="form.periodo" :items="periodos" item-title="name" item-value="id"></v-select>
                    </div>
                    <label for="anio" class="absolute text-md text-gray-500 dark:text-gray-400  bg-white  left-1 pb-4 mb-5 ml-5">Año: </label>
                    <div class="pt-5">
                        <v-select v-model="form.anio" :items="fullYears" item-title="name" item-value="id"></v-select>
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
