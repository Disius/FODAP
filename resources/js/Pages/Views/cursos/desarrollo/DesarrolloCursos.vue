<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import DialogPIFAP from "@/Pages/Views/dialogs/DialogPIFAP.vue";
import NavLink from "@/Components/NavLink.vue";
import {FODAPStore} from "@/store/server.js";

const props = defineProps({
  cursos: Array,
  auth: Object,
});

const store = FODAPStore()
const pdf_dialog = ref(false);

const estado = computed(() => {
   if (props.cursos.length === 0){
        return 1;
   }else{
       return 0
   }
});
console.log(store.course)

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
    store.getCursos()


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
<!--                      <TablaCursoDesarrollo :cursos="props.cursos" :user="props.auth"></TablaCursoDesarrollo>-->
                      <v-table fixed-header height="400px">
                          <thead>
                          <tr>
                              <th class="text-left">Nombre de los
                                  Cursos</th>
                              <th class="text-left">Objetivo</th>
                              <th class="text-left">Fecha de
                                  realización</th>
                              <th class="text-left">Lugar
                                  (presencial
                                  o virtual)
                              </th>
                              <th class="text-left">Horario
                              </th>
                              <th class="text-left">No. de
                                  horas
                                  x
                                  Curso
                              </th>
                              <th class="text-left">
                                  Facilitador (a)
                              </th>
                              <th class="text-left">Dirigido a:</th>
                              <th class="text-left">Observaciones
                              </th>
                              <th>
                                  Estado
                              </th>
                              <th class="text-left">Ver Inscritos

                              </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr
                              v-for="curso in store.state_inicio_curso"
                              :key="curso.id"

                          >
                              <td class="v-card--hover">
                                  {{ curso.nombreCurso }}
                              </td>
                              <td class="v-card--hover">
                                  {{ curso.objetivoEvento }}
                              </td>
                              <td class="v-card--hover">
                                  {{ curso.fecha_I }} al {{curso.fecha_F}}
                              </td>
                              <td class="v-card--hover">
                                  <template v-if="curso.modalidad === 1">
                                      <span>Virtual</span>
                                  </template>
                                  <template v-if="curso.modalidad === 2">
                                      <span>Presencial</span>
                                  </template>
                                  <template v-if="curso.modalidad === 3">
                                      <span>Hibrído</span>
                                  </template>
                              </td>
                              <td class="v-card--hover">
                                  {{ curso.hora_I }} a {{curso.hora_F}}
                              </td>
                              <td class="v-card--hover">
                                  {{curso.total_horas}}
                              </td>
                              <td class="v-card--hover">
                                  <template
                                      v-for="facilitador in curso.deteccion_facilitador"
                                  >
                                      <br> • {{facilitador.nombre}} {{facilitador.apellidoPat}} {{facilitador.apellidoMat}}
                                  </template>
                                  <template
                                      v-if="curso.facilitador_externo"
                                  >
                                      {{curso.facilitador_externo}}
                                  </template>
                              </td>
                              <td class="v-card--hover">
                                  {{ curso.carrera.nameCarrera }}
                              </td>
                              <td class="v-card--hover">
                                  {{ curso.observaciones }}
                              </td>
                              <td class="v-card--hover">
                                  <div v-if="curso.estado === 0">
                                      <v-alert min-width="100" color="warning">Por realizarse</v-alert>
                                  </div>
                                  <div v-else-if="curso.estado === 1">
                                      <v-alert min-width="100" color="success">En curso</v-alert>
                                  </div>
                                  <div v-else>
                                      <v-alert min-width="150" color="error">Finalizado</v-alert>
                                  </div>
                              </td>
                              <td class="v-card--hover">
                                  <NavLink :href="route('index.desarrollo.inscritos', curso.id)" type="button" as="button">
                                      <v-btn icon color="blue">
                                          <v-icon>mdi-eye-arrow-right-outline</v-icon>
                                      </v-btn>
                                  </NavLink>
                              </td>

                          </tr>
                          </tbody>
                      </v-table>
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
