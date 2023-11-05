import {defineStore} from "pinia";
import {curso_get} from "@/services/API.js";


export const Curso = defineStore('Curso', {
    state: () => {
        return {
            curso: {},
            inscritos: [],
        }
    },
    getters: {
        my_inscritos(state){
            return state.inscritos
        }
    },
    actions: {
        get_curso(id_curso){
          curso_get(id_curso).then(res => {
              this.inscritos = res.docente_inscrito
          }).catch(err => {
              console.log(err)
          })
        },
        update_inscritos(inscritos){
            this.inscritos = inscritos
        }
    }
})
