<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCursoDesarrollo from "@/Pages/Views/cursos/tablas/TablaCursoDesarrollo.vue";
import {onMounted, ref} from "vue";
import DialogPIFAP from "@/Pages/Views/dialogs/DialogPIFAP.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
  cursos: Array,
  auth: Object,
});

const pdf_dialog = ref(false);

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

    <v-container>
        <v-row justify="end">
            <v-col cols="12">
                <v-btn prepend-icon="mdi-file-pdf-box" size="large" @click="pdf_dialog = true" color="blue-darken-1">
                    Generar PIFDAP
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <DialogPIFAP v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DialogPIFAP>
        <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
            <TablaCursoDesarrollo :cursos="props.cursos" :user="props.auth"></TablaCursoDesarrollo>
          </div>
        </div>
      <div class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
              <div class="flex justify-center items-center">
                  <NavLink :href="route('create.curso')">
                      <v-btn block size="large" color="blue-darken-1" prepend-icon="mdi-pencil">
                          Crear Curso
                      </v-btn>
                  </NavLink>
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
