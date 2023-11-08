import {defineStore} from "pinia";
import {facilitador_check, get_dates} from "@/services/API.js";
import { administrador } from "@/services/API.js";

export const FODAPStore = defineStore('FODAP', {
    state: () => {
        return {
            admin_user: null,
            if_facilitador: null,
            dates_enable: [],
        }
    },
    getters: {
        if_admin(state){
            return state.admin_user
        },
        this_facilitador(state) {
          return state.if_facilitador;
        },
        si_dates(state){
            return state.dates_enable
        }
    },
    actions: {
        admin_get(){
            administrador().then(res => {
                this.admin_user = res
            }).catch(err => {
                console.log(err)
            })
        },
        get_is_facilitador(id){
            facilitador_check(id).then(res => {
                this.if_facilitador = res
            }).catch(err => {
                console.log(err)
            })
        },
        if_enable_fechas(){
            get_dates().then(res => {
                this.dates_enable = res
            }).catch(err => {
                console.log(err.response.data)
            })
        },
        update_enable_dates(dates){
          this.dates_enable = dates
        }
    }
})
