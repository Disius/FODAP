<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {onMounted, reactive, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {FODAPStore} from "@/store/server.js";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
const props = defineProps({
    auth: Object,
    docente: Object,
    curso: Object,
})

const timeout = ref(0)
const message = ref("")
const color = ref("")
const snackbar = ref(false)
const store = FODAPStore()


const rules = [
    v => v.length <= 250 || 'Maximo 250 caracteres'
]
const matrix = ref( [ ['', '', ''], ['', '', ''], ['', '', ''] ]);
const c_eval = ref( [ ['', '', ''], ['', '', ''], ['', '', ''] ]);

const form = useForm({
    id_curso: props.curso.id,
    id_docente: props.docente.id,
    introduccion: "",
    justificacion: "",
    objetivo_general: "",
    descripcion_servicio: "",
    temas: [ ['', '', ''], ['', '', ''], ['', '', ''] ],
    elementos_didacticos: "",
    criterio_eval: [ ['', '', ''], ['', '', ''], ['', '', ''] ],
    competencias_desarrollar: "",
    fuentes_informacion: "",
    tipo_servicio: props.curso.tipo_actividad,
    duracion: props.curso.total_horas
});

// const addCol = () => {
//     matrix.value.forEach(row => {
//         row.push('');
//     });
// }
// const  = () => {
//     matrix.value.forEach(row => {
//         row.push('');
//     });
// }

const addRow = () => {
    return form.temas.length === 14 ? snacktemas() : form.temas.push(['', '', ''])
}
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(()=>{
        snackbar.value = false
    }, timeout.value)
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(()=>{
        snackbar.value = false
    }, timeout.value)
};
const snacktemas = () => {
    snackbar.value = true;
    message.value = "Maxino de temas alcanzados"
    color.value = "warning"
    timeout.value = 5000
    setTimeout(()=>{
        snackbar.value = false
    }, timeout.value)
};
const submit = () => {
    form.post(route('store.ficha'), {
        onSuccess: () => {
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}

onMounted(() => {
    store.get_is_facilitador(props.auth.user.docente_id)
    //
    // console.log(store.this_facilitador)
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Crear Ficha Técnica</h2>
        </template>
        <div class="mt-5 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
               <form @submit.prevent="submit">
                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Introducción: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>En un máximo de 250 palabras de una breve introducción del curso.</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.introduccion" :counter="800"></v-textarea>
                       </div>
                   </div>
                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Justificación: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>Se debe describir las razones que sustentan la realización de la capacitación</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.justificacion"></v-textarea>
                       </div>
                   </div>
                   <div class="grid grid-cols-1 justify-center">
                       <strong class="text-xl">Objetivo General: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>Describir la finalidad del servicio.</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.objetivo_general" :counter="800"></v-textarea>
                       </div>
                   </div>
                   <div class="flex justify-start">
                       <strong class="text-xl">Contenido temático del curso: </strong>
                   </div>
                   <div class="flex justify-center">
                       <v-alert
                           icon="$info"
                           color="info"
                       >
                           <div class="text-2xl">Deben ser maximo 14 y solo debe indicar el tema</div>
                       </v-alert>
                   </div>
                       <v-row justify="center" class="mt-2">
                           <v-col cols="3" align="center" class="mr-10">
                               <div class="d-flex justify-center">
                                   <v-tooltip location="right">
                                       <template v-slot:activator="{ props }">
                                           <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                               <v-icon>
                                                   mdi-help
                                               </v-icon>
                                           </v-btn>
                                       </template>
                                       <span>Temas que se abordaran en el servicio de capacitación.</span>
                                   </v-tooltip>
                               </div>
                               <strong class="text-lg">Tema</strong>
                           </v-col>
                           <v-col cols="3" align="center">
                               <div class="">
                                   <v-tooltip location="right">
                                       <template v-slot:activator="{ props }">
                                           <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                               <v-icon>
                                                   mdi-help
                                               </v-icon>
                                           </v-btn>
                                       </template>
                                       <span>Colocar el tiempo destinado para cada tema en horas. Solo incluir NÚMERO</span>
                                   </v-tooltip>
                               </div>
                               <strong class="text-lg">Tiempo Programado (Hrs) </strong>
                           </v-col>
                           <v-col cols="3" align="center">
                               <div class="">
                                   <v-tooltip location="right">
                                       <template v-slot:activator="{ props }">
                                           <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                               <v-icon>
                                                   mdi-help
                                               </v-icon>
                                           </v-btn>
                                       </template>
                                       <span>Describir las actividades de aprendizaje que se desarrollaran por tema.</span>
                                   </v-tooltip>
                               </div>
                               <strong class="text-lg">Actividades de aprendizaje </strong>
                           </v-col>
                       </v-row>
                   <v-container>
                       <v-row v-for="(row, rowIndex) in form.temas" :key="rowIndex" class="matrix-row">
                           <v-col v-for="(field, colIndex) in row" :key="colIndex" class="matrix-col">
                               <v-textarea v-model="form.temas[rowIndex][colIndex]" label="" dense></v-textarea>
                           </v-col>
                       </v-row>
                   </v-container>
                   <v-row justify="center">
                       <v-col cols="6" align="center">
                           <v-btn @click="addRow" color="blue-darken-1">Agregar Fila</v-btn>
                       </v-col>
                   </v-row>

                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Elementos didácticos para el desarrollo del curso: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>Describir los elementos de apoyo que requerirá el instructor para la realización del servicio (Computadora, Software, proyector, entre otros)</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.elementos_didacticos" :counter="250" :rules="rules"></v-textarea>
                       </div>
                   </div>
                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Criterio de evaluación: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>minimo 3 criterios</span>
                           </v-tooltip>
                       </div>
                       <v-container fluid>
                           <v-row justify="center">
                               <v-col cols="2" align="center">
                                   <div class="mb-2">
                                       <v-tooltip location="right">
                                           <template v-slot:activator="{ props }">
                                               <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                   <v-icon>
                                                       mdi-help
                                                   </v-icon>
                                               </v-btn>
                                           </template>
                                           <span>Criterios de evaluación.</span>
                                       </v-tooltip>
                                   </div>
                                   <strong class="text-lg">Criterio.</strong>
                               </v-col>
                               <v-col cols="2" align="center">
                                   <div class="mb-2">
                                       <v-tooltip location="top">
                                           <template v-slot:activator="{ props }">
                                               <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                   <v-icon>
                                                       mdi-help
                                                   </v-icon>
                                               </v-btn>
                                           </template>
                                           <span>Porcentaje asignado a cada criterio de evaluación. No es necesario asignar el simbolo de PORCENTAJE</span>
                                       </v-tooltip>
                                   </div>
                                   <strong class="text-lg">Valor</strong>
                               </v-col>
                               <v-col cols="2" align="center">
                                   <div class="mb-2">
                                       <v-tooltip location="right">
                                           <template v-slot:activator="{ props }">
                                               <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                                   <v-icon>
                                                       mdi-help
                                                   </v-icon>
                                               </v-btn>
                                           </template>
                                           <span>Especificar el instrumento de evaluacion que se utilizará y adjuntar a la ficha tecnica, evidencia de un participante del servicio.</span>
                                       </v-tooltip>
                                   </div>
                                   <strong class="text-lg">Instrumento de evaluación </strong>
                               </v-col>
                           </v-row>
                       </v-container>
                       <v-container>
                           <v-row v-for="(row, rowIndex) in form.criterio_eval" :key="rowIndex" class="matrix-row">
                               <v-col cols="2" v-for="(field, colIndex) in row" :key="colIndex" class="matrix-col">
                                   <v-textarea v-model="form.criterio_eval[rowIndex][colIndex]" label="" dense></v-textarea>
                               </v-col>
                           </v-row>
                       </v-container>
                   </div>
                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Competencias a desarrollar: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>Describir los elementos de apoyo que requerirá el instructor para la realización del servicio (Computadora, Software, proyector, entre otros)</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.competencias_desarrollar"></v-textarea>
                       </div>
                   </div>
                   <div class="grid grid-cols-1">
                       <strong class="text-xl">Fuentes de Información: </strong>
                       <div class="d-flex justify-start mb-5 ml-3">
                           <v-tooltip location="right">
                               <template v-slot:activator="{ props }">
                                   <v-btn icon v-bind="props" color="blue-darken-1" size="normal">
                                       <v-icon>
                                           mdi-help
                                       </v-icon>
                                   </v-btn>
                               </template>
                               <span>Colocar la bibliografía en formato APA para la elaboración y desarrollo del servicio.</span>
                           </v-tooltip>
                       </div>
                       <div class="flex justify-center mt-2">
                           <v-textarea clearable variant="solo" v-model="form.fuentes_informacion"></v-textarea>
                       </div>
                   </div>
                   <v-container>
                       <v-row justify="center">
                           <v-btn type="submit" color="blue-darken-1" icon="mdi-content-save-all" size="x-large" class="floating-btn">

                           </v-btn>
                       </v-row>
                   </v-container>
               </form>
            </div>
        </div>
        <CustomSnackBar :message="message" :color="color" v-model="snackbar" @update:modelValue="snackbar = $event" :timeout="timeout">

        </CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>
.matrix {
    display: flex;
    flex-direction: column;
}

.matrix-row {
    display: flex;
    justify-content: center;
    align-content: center;
}

.matrix-col {
    margin: 8px;
}
.floating-btn {
    position: fixed;
    bottom: 50px; /* Ajusta la posición vertical como desees */
    right: 200px; /* Ajusta la posición horizontal como desees */
    z-index: 1000; /* Ajusta el z-index según tus necesidades para asegurarte de que esté por encima de otros elementos. */
    width: 80px;
    height: 80px;
}
</style>
