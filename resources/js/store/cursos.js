import {defineStore} from "pinia";
import {computed, ref} from "vue";


export const cursoStore = defineStore('cursos', {
    state: () => {
        return {
            cursos: []
        }
    },
    getters: {
        course(state){
            return state.cursos
        },
        FDCourse(state){
            return state.cursos.filter(c => {
                return c.tipo_FDoAP === 1
            })
        },
        APCourse(state){
          return state.cursos.filter(c => {
              return c.tipo_FDoAP === 2
          })
        },
        anio_realizacion(state){
            let date = new Date(state.cursos[0].created_at);
            return date.getFullYear()
        }
    },
    actions: {
        getCursos(curso){
            this.cursos = curso
        }
    }
})
