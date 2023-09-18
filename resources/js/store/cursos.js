import {defineStore} from "pinia";
import {computed, ref} from "vue";


export const cursoStore = defineStore('cursos', {
    state: () => {
        return {
            cursos: []
        }
    },
    getters: {
        course(){
            return computed(() => this.cursos)
        }
    },
    actions: {
        getCursos(curso){
            this.cursos = curso
        }
    }
})
