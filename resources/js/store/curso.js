import {defineStore} from "pinia";
import {
    curso_data_get,
    cursos_academicos,
    cursos_desarrollo,
    inscritos_get,
} from "@/services/API.js";


export const Curso = defineStore('Curso', {
    state: () => {
        return {
            desarrollo_cursos: [],
            academicos_cursos: [],
            inscritos: [],
            inscritos_desarrollo: [],
            inscritos_academicos: [],
            inscritros_facilitador: [],

            curso_info: {},
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
        set_cursos_academicos_begin(state){
          return state.academicos_cursos.filter(curso => {
              return curso.estado === 0 || curso.estado === 1
          });
        },
        set_cursos_academicos_end(state){
          return state.academicos_cursos.filter(curso => {
              return curso.estado === 2
          });
        },
        my_inscritos(state){
            return state.inscritos
        },
        my_inscritos_desarrollo(state){
            return state.inscritos_desarrollo
        },
        my_inscritos_academicos(state){
            return state.inscritos_academicos
        },
        inscritos_calificacion(state){
            return state.inscritos_desarrollo.every(inscrito => inscrito.calificacion !== null);
        },
        curso_Info(state){
            return state.curso_info
        }
    },
    actions: {
        get_curso_desarrollo(){
            cursos_desarrollo().then(res => {
                this.desarrollo_cursos = res
            }).catch(err => {
                console.log(err)
            })
        },
        get_cursos_academicos(){
          cursos_academicos().then(res => {
              this.academicos_cursos = res
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
        inscritos_curso_desarrollo(id_curso){
          inscritos_get(id_curso).then(res => {
              this.inscritos_desarrollo = res
          }).catch(err => {
              console.log(err)
          })
        },
        inscritos_curso_academicos(id_curso){
          inscritos_get(id_curso).then(res => {
              this.inscritos_academicos = res
          }).catch(err => {
              console.log(err)
          })
        },
        update_inscritos(inscritos){
            this.inscritos = inscritos
        },
        update_inscritos_desarrollo(inscritos){
            this.inscritos_desarrollo = inscritos
        },
        update_inscritos_academicos(inscritos){
            this.inscritos_academicos = inscritos
        },
        update_calificacion(inscrito){
            const indice =  this.inscritos.findIndex((cal) => cal.id === inscrito.id);
            if (indice !== -1) {
                this.inscritos[indice] = inscrito;
            }
        },
        update_calificacion_desarrollo(inscrito){
            const indice =  this.inscritos_desarrollo.findIndex((cal) => cal.id === inscrito.id);
            if (indice !== -1) {
                this.inscritos_desarrollo[indice] = inscrito;
            }
        },
        update_calificacion_academicos(inscrito){
            const indice =  this.inscritos_academicos.findIndex((cal) => cal.id === inscrito.id);
            if (indice !== -1) {
                this.inscritos_academicos[indice] = inscrito;
            }
        },
        curso_aceptado_update(curso){
            this.academicos_cursos.unshift(curso)
        },

        infoCourse(id){
            curso_data_get(id).then(res =>{
                this.curso_info = res
            }).catch(err =>
            console.log(err.data.response)
            )
        }
    }
})
