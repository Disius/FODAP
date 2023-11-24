<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import DialogPIFAP from "@/Pages/Views/dialogs/DialogPIFAP.vue";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const curso_store = Curso()

const props = defineProps({
  cursos: Object,
  auth: Object,
});


const pdf_dialog = ref(false);
const search = ref("");
const estado = computed(() => {
   if (props.cursos.length === 0){
        return 1;
   }else{
       return 0
   }
});
const setColor = (state) => {
    if (state === 0){
        return 'warning';
    }else {
        return 'success'
    }
}
const headers = ref([
    {align: 'start', key: 'nombreCurso', sortable: false, title: 'Nombre de los Cursos'},
    { key: 'objetivoEvento', title: 'Objetivo' },
    { key: 'fechas', title: 'Fecha de realizacion' },
    { key: '', title: 'Lugar (presencial o virtual)' },
    { key: 'horarios', title: 'Horario' },
    { key: 'total_horas', title: 'No. de horas x Curso' },
    { key: 'facilitadores', title: 'Facilitador (a)' },
    { key: 'dirigido', title: 'Dirigido a:' },
])



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

    curso_store.get_curso_desarrollo()

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
      <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
              <template v-if="props.cursos.length !== 0">
                  <v-data-iterator
                      :items="props.cursos"
                      item-value="nombreCurso"
                      :search="search"
                  >
                      <template v-slot:header>
                          <v-text-field
                              v-model="search"
                              clearable
                              density="comfortable"
                              hide-details
                              placeholder="Buscar"
                              prepend-inner-icon="mdi-magnify"
                              style="max-width: 300px;"
                              variant="solo"
                          >

                          </v-text-field>
                      </template>
                      <template v-slot:default="{items}">
                          <v-container class="pa-2 pt-15" fluid>
                              <v-row dense>
                                  <v-col v-for="item in items" :key="item.nameCarrera"
                                         cols="auto"
                                         md="6"
                                  >
                                      <v-card class="pb-3" border flat width="600">
                                          <v-list-item class="mb-2" :subtitle="item.raw.asignaturaFA">
                                              <template v-slot:title>
                                                  <strong class="text-h6 mb-2">
                                                      {{item.raw.nombreCurso}}
                                                  </strong>
                                              </template>
                                          </v-list-item>
                                          <div class="d-flex justify-space-between px-4">
                                              <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                  <template v-if="item.raw.tipo_FDoAP === 1">
                                                      <p class="text-truncate">Formación Docente</p>
                                                  </template>
                                                  <template v-if="item.raw.tipo_FDoAP === 2">
                                                      <p>Actualización Profesional</p>
                                                  </template>
                                              </div>
                                          </div>
                                          <div class="d-flex justify-space-between px-4">
                                              <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                  <p class="text-truncate">Dirigido a la academica de {{item.raw.carrera.nameCarrera}}</p>
                                              </div>
                                          </div>
                                          <div class="d-flex justify-space-between px-4 pt-4">
                                              <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                  <template v-if="item.raw.estado === 0">
                                                      <v-chip variant="flat" color="warning" prepend-icon="$info">
                                                          Curso por realizar
                                                      </v-chip>
                                                  </template>
                                                  <template v-else>
                                                      <v-chip variant="flat" color="success" prepend-icon="$info">
                                                          En curso
                                                      </v-chip>
                                                  </template>
                                              </div>
                                              <NavLink :href="route('index.desarrollo.inscritos', item.raw.id)" type="button" as="button">
                                                  <v-btn
                                                      border
                                                      flat
                                                      size="small"
                                                      class="text-none"
                                                      text="Ver"
                                                      prepend-icon="mdi-eye-arrow-right-outline"
                                                  >
                                                  </v-btn>
                                              </NavLink>
                                          </div>
                                      </v-card>
                                  </v-col>
                              </v-row>
                          </v-container>
                      </template>
                  </v-data-iterator>
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
          </div>
      </div>


      <div class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
              <v-row justify="center" class="">
                  <v-col xs="9" sm="8" lg="6" cols="6" align="center">
                      <NavLink :href="route('index.registros.c')" as="button">
                          <v-btn block size="large" color="blue-darken-1" prepend-icon="mdi-archive" height="50"
                                 width="550">
                              Ver todos los registros
                          </v-btn>
                      </NavLink>
                  </v-col>
                  <v-col sm="9" lg="6" cols="6" align="center">
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
