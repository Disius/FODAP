import axios from 'axios';
import {computed, ref} from 'vue';
import { jsPDF } from "jspdf";

let cursos = ref();

let img = document.createElement('img')
img.src = '/storage/img/ITTG.png';
const nameI = "INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ";
export default function getCursos(curso){
    cursos.value = curso
}

function generateDeteccionPDF(){
    const doc = new jsPDF();
    doc.setFontSize(12);
    doc.setFont("Times-Roman");
    doc.addImage(img, 'PNG', 28, 14.5, 11.5, 10.5)
    doc.text(nameI, 48, 21);

    doc.setFontSize(10)
    doc.setFont("Times-Roman")
    doc.text("Subdirección Académica", 60, 40)
    doc.save('deteccion.pdf')
}

export function event_download_deteccion(){
    generateDeteccionPDF()
}
