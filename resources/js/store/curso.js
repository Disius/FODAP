import {defineStore} from "pinia";
import {inscritos_get} from "@/services/API.js";


export const Curso = defineStore('Curso', {
    state: () => {
        return {
            inscritos: [],
        }
    },
    getters: {
        my_inscritos(state){
            return state.inscritos
        },
    },
    actions: {
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
