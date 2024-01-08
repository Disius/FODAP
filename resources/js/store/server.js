import {defineStore} from "pinia";
import {facilitador_check, get_dates, notifications_number} from "@/services/API.js";
import { administrador } from "@/services/API.js";
import {notifications} from "@/services/API.js";

export const FODAPStore = defineStore('FODAP', {
    state: () => {
        return {
            admin_user: null,
            if_facilitador: null,
            dates_enable: [],
            notificaciones: [],
            numero_notificaciones: null,
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
        },
        set_notifications(state){
            return state.notificaciones
        },
        get_number_notification(state){
            return state.numero_notificaciones
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
        },
        notificaciones_catch(){
            notifications().then(res => {
                this.notificaciones = res
            }).catch(err => {
                console.log(err.response.data)
            })
        },
        update_notifications(notifications){
            this.notificaciones.email = notifications.email
            this.notificaciones.id = notifications.id
            this.notificaciones.messegue = notifications.messegue
            this.notificaciones.route = notifications.route
        },
        get_number_notifications(){
            notifications_number().then(r => {
                this.numero_notificaciones = r
            }).catch(err => {
                console.log(err.response.data)
            })
        },
        update_number_notifications(){
            this.numero_notificaciones++
        },
        notification_read(){
            this.numero_notificaciones--
        }
    }
})
