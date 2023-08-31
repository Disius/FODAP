<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCursoDesarrollo from "@/Pages/Views/cursos/tablas/TablaCursoDesarrollo.vue";
import {onMounted} from "vue";

const props = defineProps({
  cursos: Array,
  auth: Object,
});



onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    })
});
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
    </template>

    <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
        <TablaCursoDesarrollo :cursos="props.cursos" :user="props.auth"></TablaCursoDesarrollo>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
