import {defineStore} from "pinia";
import {cursos_desarrollo, inscritos_get} from "@/services/API.js";


export const Curso = defineStore('Curso', {
    state: () => {
        return {
            desarrollo_cursos: [],
            inscritos: [],
        }
    },
    getters: {
        set_cursos_desarrollo_begin(state){
          return state.desarrollo_cursos.filter(curso => {
              return curso.estado === 0 || curso.estado === 1
          })
        },
        set_cursos_desarrollo_end(state){
          return state.desarrollo_cursos.filter(curso => {
              return curso.estado === 2
          })
        },
        my_inscritos(state){
            return state.inscritos
        },
    },
    actions: {
        get_curso_desarrollo(){
            cursos_desarrollo().then(res => {
                this.desarrollo_cursos = res
            }).catch(err => {
                console.log(err)
            })
        },
        inscritos_curso(id_curso){
          inscritos_get(id_curso).then(res => {
              this.inscritos = res
          }).catch(err => {
              console.log(err)
          })
        },
        update_inscritos(inscritos){
            this.inscritos = inscritos
        }
    }
})
