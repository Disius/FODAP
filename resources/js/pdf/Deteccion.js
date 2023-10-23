import axios from 'axios';
import {computed, reactive, ref} from 'vue';
import { jsPDF } from "jspdf";
import {cursoStore} from '@/store/server.js'
import {storeToRefs} from 'pinia'

// const store = cursoStore()
// const { cursos } = storeToRefs(store)


//imagenes
let img = document.createElement('img')
img.src = '/storage/img/ITTG.png';

function generateDeteccionPDF(){
    const doc = new jsPDF();

    //logo y nombre de la institución
    doc.setFontSize(12);
    doc.setFont("Times-Roman");
    doc.addImage(img, 'PNG', 40, 12, 11, 11)
    doc.text("INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ", 56, 19);
    //segunda seccion, subdireccion, departamento
    doc.setFontSize(10)
    doc.setFont("Times-Roman")
    doc.text("Subdirección Académica", 88, 37)
    doc.text(`Departamento Académico: `, 52, 40)




    //save
    doc.save('deteccion.pdf')
}

export function event_download_deteccion(){
    generateDeteccionPDF()
}
