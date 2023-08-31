import {defineStore} from "pinia";
import {computed, ref} from "vue";


export const useNotificationStore = defineStore('NotificationStore', () => {
    let notifications = ref(0);

    function incrementNotification(notification){
        notifications = notification
    }

    return {notifications, incrementNotification}
})
