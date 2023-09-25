<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCursoDesarrollo from "@/Pages/Views/cursos/tablas/TablaCursoDesarrollo.vue";
import {computed, onMounted, ref} from "vue";
import DialogPIFAP from "@/Pages/Views/dialogs/DialogPIFAP.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
  cursos: Array,
  auth: Object,
});

const pdf_dialog = ref(false);

const estado = computed(() => {
   if (props.cursos.length === 0){
        return 1;
   }else{
       return 0
   }
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

    <v-container>
        <v-row justify="end">
            <v-col cols="12">
                <v-btn prepend-icon="mdi-file-pdf-box" size="large" @click="pdf_dialog = true" color="blue-darken-1">
                    Generar PDF PIFDAP
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <DialogPIFAP v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DialogPIFAP>


          <template v-if="estado === 0">
              <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                  <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                      <TablaCursoDesarrollo :cursos="props.cursos" :user="props.auth"></TablaCursoDesarrollo>
                  </div>
              </div>
          </template>
          <template v-else>
              <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                  <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                      <v-alert
                          color="blue-darken-1"
                          icon="mdi-alert-circle"
                          prominent
                      >
                          Actualmente no hay cursos por realizarse, puede visualizar todos los que se llevaron acabo al presionar  "Ver todos los registros".
                      </v-alert>
                  </div>
              </div>
          </template>


      <div class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
              <v-row justify="center" class="">
                  <v-col cols="6" align="center">
                      <NavLink :href="route('index.registros.c')" as="button">
                          <v-btn block size="large" color="blue-darken-1" prepend-icon="mdi-archive" height="50"
                                 width="550">
                              Ver todos los registros
                          </v-btn>
                      </NavLink>
                  </v-col>
                  <v-col cols="6" align="center">
                      <NavLink :href="route('create.curso')">
                          <v-btn block size="large" color="blue-darken-1" prepend-icon="mdi-pencil" height="50" width="550">
                              Crear Curso
                          </v-btn>
                      </NavLink>
                  </v-col>
              </v-row>
          </div>
      </div>

  </AuthenticatedLayout>
</template>

<style scoped>

</style>
