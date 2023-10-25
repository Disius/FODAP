import {defineStore} from "pinia";
import {cursos, cursos_docente} from "@/services/API.js";
import {detecciones} from "@/services/API.js";
import { administrador } from "@/services/API.js";

export const FODAPStore = defineStore('FODAP', {
    state: () => {
        return {
            cursos: [],
            detecciones: [],
            admin_user: null,
            docente_cursos: [],
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
        cursosDocentes(state){
            return state.docente_cursos.filter(curso => {
                return curso.estado === 0 || curso.estado === 1
            })
        },
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
        get_curso_docente(){
            cursos_docente().then(res => {
                this.docente_cursos = res
            }).catch(err => {
                console.log(err)
            })
        }

    }
})
