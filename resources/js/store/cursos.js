import {defineStore} from "pinia";
import {computed, ref} from "vue";
import axios from "axios";
import {router} from "@inertiajs/vue3";


export const cursoStore = defineStore('cursos', {
    state: () => {
        return {
            cursos: [],
            dates: []
        }
    },
    getters: {
        course(state){
            return state.cursos
        },
        // FDCourse(state){
        //     return state.cursos.filter(c => {
        //         return c.tipo_FDoAP === 1
        //     })
        // },
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
        // getCursos(){
        //     axios.get(route('call.cursos')).then(res => {
        //         this.cursos = res.data
        //     }).catch(error => {
        //         console.log(error.response.data)
        //     })
        // },
        // getTime(){
        //     axios.get(route('dates.get')).then(res => {
        //         this.dates = res.data
        //     }).catch(error => {
        //         console.log(error.response.data)
        //     })
        // }
    }
})
