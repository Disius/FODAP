import {defineStore} from "pinia";
import {computed, ref} from "vue";
import axios from "axios";
import {router} from "@inertiajs/vue3";
import {cursos} from "@/services/API.js";
import {detecciones} from "@/services/API.js";
import { administrador } from "@/services/API.js";

export const FODAPStore = defineStore('FODAP', {
    state: () => {
        return {
            cursos: [],
            detecciones: [],
            admin_user: null,
        }
    },
    getters: {
        get_detecciones(state){
            return state.detecciones
        },
        course(state){
            return state.cursos
        },
        FDCourse(state){
            return state.cursos.filter(c => {
                return c.tipo_FDoAP === 1
            })
        },
        state_inicio_curso(state){
            return state.cursos.filter(curso => {
                return curso.estado === 0 || curso.estado === 1
            })
        },
        state_final_curso(state){
            return state.cursos.filter(curso => {
                return curso.estado === 2
            })
        },
        if_admin(state){
            return state.admin_user
        },
        // APCourse(state){
        //   return state.cursos.filter(c => {
        //       return c.tipo_FDoAP === 2
        //   })
        // },
        // anio_realizacion(state){
        //     let date = new Date(state.cursos[0].created_at);
        //     return date.getFullYear()
        // },
        // isActive(state) {
        //     let hoy = new Date();
        //     let startDay = new Date(state.fecha_inicio);
        //     let endDay = new Date(state.fecha_final)
        //     return hoy >= startDay && hoy <= endDay;
        // }
    },
    actions: {
        admin_get(){
            administrador().then(res => {
                this.admin_user = res
            }).catch(err => {
                console.log(err)
            })
        },
        getDetecciones(){
            detecciones().then(res => {
                this.detecciones = res
            }).catch(err => {
                console.log(err)
            })
        },
        getCursos(){
            cursos().then(res => {
                this.cursos = res
            }).catch(err => {
                console.log(err)
            })
        },
    }
})
