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


const errorHandle = ref("");
const alert = ref(false);

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
        if (res.data.mensaje){
            alert.value = true
            errorHandle.value = res.data.mensaje
        }else {
            getCursos(res.data.cursos)
            pdfGenerate()
            form.reset()
        }

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


        const doc = new jsPDF('p', 'cm', 'a4');

        //logo y nombre de la institución
        doc.setFontSize(12);
        doc.setFont("Arial")
        doc.addImage(img2, 'JPG', 4, 1.1, 1.2, 1)
        doc.text("INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ", 5.7, 1.7);

        //segunda seccion, subdireccion, departamento
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text("Subdirección Académica", 8.8, 3.1)
        doc.text(`Departamento Académico: ${store.course[0].departamento.nameDepartamento}`, 5.9, 3.5)

        //tercera seccion
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text("DIAGNÓSTICO DE NECESIDADES DE", 7.8, 4.3)
        doc.text("FORMACIÓN DOCENTE Y ACTUALIZACIÓN PROFESIONAL", 6, 4.7)

        //cuarta seccion
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text(`PARA LAS(OS) PROFESORAS(ES) DE LA ACADEMIA DE: ${store.course[0].carrera.nameCarrera}`, 3.6, 5.8)
        doc.setFontSize(10)
        doc.setFont("Arial", 'normal')
        doc.text(`Fecha de realización del diagnóstico: ${store.anio_realizacion}`, 3.6, 6.3)

        //tablas
        doc.setFontSize(10)
        doc.setFont("Arial", 'normal')
        doc.text('Jefa (e) del Departamento Académico', 3.6, 6.9)

        autoTable(doc, {
            margin: {left: 3, right: 4},
            styles: {
                fontSize: 10,
                lineWidth: 0.01,
                lineColor: [0,0,0]
            },
            tableWidth: 13,
            theme: 'plain',
            columnStyles: { 0: { cellWidth: 8 }, 1: { cellWidth: 8} },
            startY: 7.0,
            startX: 3.5,
            head: [['Nombre', 'Firma']],
            body: [
                [[store.course[0].jefe.nombre_completo]],
                // ...
            ],
        })

        doc.setFontSize(10)
        doc.setFont("Arial", 'normal')
        doc.text('Presidenta (e) de Academia', 3.6, 9)

        autoTable(doc, {
            margin: {left: 3, right: 4},
            tableWidth: 13,
            theme: 'plain',
            columnStyles: { 0: { cellWidth: 8 }, 1: { cellWidth: 8} },

            styles: {
                fontSize: 10,
                lineWidth: 0.01,
                lineColor: [0,0,0],
            },
            head: [['Nombre', 'Firma']],
            body: [
                [[]],
                // ...
            ],
        })

        //concentrado
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text('a)', 4.2, 11.5)
        doc.text('PRIORIZAR LAS DIMENSIONES DE LA EVALUACIÓN DOCENTE EN LAS QUE', 4.8, 11.5)
        doc.text('REQUIERE LA FORMACIÓN DOCENTE DE EL/LA PROFESOR(A), AVALADOS.', 4.8, 11.9)
        doc.text('POR LA ACADEMIA.', 4.8, 12.3)

        //tabla formacion docente
        let curso_FD = [];
        store.FDCourse.forEach((element, index, array) => {
            let facilitadores = []
            let period
            let m = ''
            for (let f of element.deteccion_facilitador){
                facilitadores.push([f.nombre_completo])
            }
            let facilitadores_name = facilitadores.join(". ")

            element.periodo === 1 ? period = 'ENERO - JUNIO' : period = 'AGOSTO - DICIEMBRE'
            switch (element.modalidad){
                case 1:
                    m = "Virtual"
                    break;
                case 2:
                    m = "Presencial"
                    break;
                case 3:
                    m = "Hibrido";
                    break;

            }
            curso_FD.push([element.asignaturaFA, element.contenidosTM, element.numeroProfesores, period, facilitadores_name, m])
        });
        let columns = [
            {title: 'Dimensión(es) en la(s) que se requiere Formación Docente'},
            {title: 'Competencia(s) en la(s) que se requiere la Formación Docente'},
            {title: 'Número de profesores(as) que requieren Formación Docente'},
            {title: 'Periodo en el que se requiere la Formación Docente (enero-junio o agosto diciembre)'},
            {title: 'Facilitador (a) que impartirá el curso/taller'},
            {title: 'Modalidad'},
        ];
        autoTable(doc, {
            theme: 'plain',
            margin: {left: 3, right: 4},
            tableWidth: 15.5,
            startY: 12.6,
            rowPageBreak: 'avoid',
            styles: {
                fontSize: 10,
                lineWidth: 0.01,
                lineColor: [0,0,0],
                overflow: 'linebreak'
            },
            head: [columns],
            body: curso_FD,
        })

    //titulo de concentrado
        let finalY = doc.lastAutoTable.finalY;
        doc.setFontSize(10)
        doc.setFont("Arial", 'bold')
        doc.text('b)', 4.2, finalY + 0.8)
        doc.text('PRIORIZAR LAS ASIGNATURAS EN LAS QUE REQUIERE ACTUALIZACIÓN', 4.8, finalY + 0.8)
        doc.text('PROFESIONAL DE EL/LA PROFESOR(A), AVALADOS POR LA ACADEMIA.', 4.8, finalY + 1.2)


        doc.setFontSize(8)
        doc.setFont("Tahoma", 'bold')
        doc.text("Nota: La formación docente estará atendida prioritariamente con el Programa Nacional de Formación Docente", 3.7, finalY + 6.8)
        doc.text("Centrado en el Aprendizaje (Formación DOCA)", 3.7, finalY + 7.0)
        doc.setFont("Arial", 'normal')
        doc.text("ITTG-AC-PO-006-01", 3.7, finalY + 7.7)
        doc.text(`Rev.${0}`, 16.5, finalY + 7.7)


        // tabla de actualizacion profesional
        let curso_AP = [];
        store.APCourse.forEach((element, index, array) => {
            let facilitadores = []
            let period = ''
            let m = ''
            for (let f of element.deteccion_facilitador){
                facilitadores.push([f.nombre_completo])
            }
            let facilitadores_name = facilitadores.join(". ")

            element.periodo === 1 ? period = 'ENERO - JUNIO' : period = 'AGOSTO - DICIEMBRE'
            switch (element.modalidad){
                case 1:
                    m = "Virtual"
                    break;
                case 2:
                    m = "Presencial"
                    break;
                case 3:
                    m = "Hibrido";
                    break;

            }
            curso_AP.push([element.asignaturaFA, element.contenidosTM, element.numeroProfesores, period, facilitadores_name, m])
        });
        let columns2 = [
            {title: 'Asignatura(s) en la(s) que se requiere Actualización profesionalAsignatura(s) en la(s) que se requiere Actualización profesional'},
            {title: 'Contenidos temáticos en que se requiere Actualización Profesional'},
            {title: 'Número de profesores (as) que requieren Actualización Profesional'},
            {title: 'Periodo en el que se requiere la Actualización Profesional (enero-junio o agosto diciembre)'},
            {title: 'Facilitador (a) que impartirá el curso/taller'},
            {title: 'Modalidad'},
        ];

        autoTable(doc, {
            margin: {left: 3, right: 4},
            tableWidth: 15.5,
            theme: 'plain',
            startY: finalY + 1.5,
            rowPageBreak: "avoid",
            showHead: "firstPage",
            styles: {
                fontSize: 10,
                lineWidth: 0.01,
                lineColor: [0,0,0],
                overflow: "linebreak"
            },
            head: [columns2],
            body: curso_AP,

        })


        



    window.open(doc.output('bloburl', {
        filename: 'deteccion.pdf'
    }))
        //save
        // doc.save('deteccion.pdf')
}

</script>

<template>
    <v-dialog width="auto" persistent v-model="props.modelValue">
        <form @submit.prevent="submit">
            <v-card elevation="3" width="500" height="500">
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
