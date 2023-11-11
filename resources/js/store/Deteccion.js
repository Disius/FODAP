import {defineStore} from "pinia";
import {detecciones_academicos, detecciones_desarrollo} from "@/services/API.js";


export const Deteccion = defineStore('Deteccion', {
    state: () => {
        return {
            detecciones: [],
            academicosDetecciones: [],
        }
    },
    getters: {
        detecciones_desarrollo(state){
            return state.detecciones
        },
        detecciones_academico(state){
            return state.academicosDetecciones
        }
    },
    actions: {
        getDeteccionesDesarrollo(){
            detecciones_desarrollo().then(res => {
                this.detecciones = res
            }).catch(err => {
                console.log(err)
            })
        },
        update_detecciones_desarrollo(deteccion){
            this.detecciones.unshift(deteccion)
        },
        deteccionesAcademico(){
            detecciones_academicos().then(res => {
                this.academicosDetecciones = res
            }).catch(err => {
                console.log(err)
            })
        },
        update_detecciones_academicos(deteccion){
            const indice =  this.academicosDetecciones.findIndex((detec) => detec.id === deteccion.id);
            if (indice !== -1) {
                this.academicosDetecciones[indice] = deteccion;
            }
        },
        delete_deteccion_academicos(id){
            this.academicosDetecciones = this.academicosDetecciones.filter(c => c.id !== id)
        },
        delete_deteccion_desarrollo(id){
            this.detecciones = this.detecciones.filter(d => d.id !== id)
        }
    }
});
