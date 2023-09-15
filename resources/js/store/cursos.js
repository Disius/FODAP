import {defineStore} from "pinia";
import {computed, ref} from "vue";


export const cursoStore = defineStore('cursos', {
    state: () => {
        return {
            cursos: []
        }
    },

    actions: {
        getCursos(curso){
            this.cursos = curso
        }
    }
})
