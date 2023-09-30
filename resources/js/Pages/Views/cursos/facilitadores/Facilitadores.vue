<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import {fi} from "vuetify/locale";
import {router, useForm} from "@inertiajs/vue3";
import axios from "axios";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
   auth: Object,
   docente: Object
});


const form = useForm({
    file: null,
    id: props.auth.user.docente_id
});

const download_cvu = () => {
    const url = '/storage/CVUdownload/CVUEditable.docx';
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'CVUEditable.docx');
    document.body.appendChild(link);
    link.click();
}

const upload_file = () => {
    form.post(route('upload.cvu'), {
        forceFormData: true
    })
}

const formFT = useForm({
    id: props.auth.user.docente_id,
    file: null
})

const upload_file_ft = () => {

}
const download_cvu_editado = () => {
    let url = '/storage' + '/' + props.docente.cvu.path
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'CVU.pdf');
    document.body.appendChild(link);
    link.click();
}


const download_ft = () => {
    const url = '/storage/FTDownload/fichatécnica.docx';
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'FichaTécnicaEditable.docx');
    document.body.appendChild(link);
    link.click();
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Facilitadores</h2>
        </template>


        <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex justify-items-center mb-12">
                    <h2 class="text-xl font-medium text-gray-900 text-center">CVU</h2>
                </div>
                <div class="flex justify-center w-50">
                    <v-btn block height="50" color="blue-darken-1" @click="download_cvu">Descargar para editar</v-btn>
                </div>
                <div class="grid grid-cols-2">
                    <div class="flex justify-start mt-12">
<!--                        <input name="file" type="file" @input="form.file = $event.target.files[0]">-->
<!--                        <input-label for="cvu" value="Ingresar CVU"></input-label>-->
                        <v-file-input label="Ingresar CVU" variant="solo" @input="form.file = $event.target.files[0]"></v-file-input>
                    </div>
                    <div class="flex justify-center mt-12">
                        <v-btn color="blue-darken-1" @click="upload_file" width="500" height="50">
                            Subir
                        </v-btn>
                    </div>
                </div>
                <template v-if="props.docente.cvu != null">
                    <div class="flex justify-start mt-5">
                        <v-btn color="blue-darken-1" width="500" @click="download_cvu_editado">DESCARGAR MI CVU</v-btn>
                    </div>
                </template>
            </div>
        </div>
        <div class="mt-5 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex justify-items-center mb-12">
                    <h2 class="text-xl font-medium text-gray-900 text-center">FICHA TÉCNICA</h2>
                </div>

                <div class="grid grid-cols-2">
                    <div class="flex justify-center mr-5">
                        <v-btn block height="50" color="blue-darken-1">Descargar PDF</v-btn>
                    </div>
                </div>
                <div class="flex justify-start">
                    <h2 class="text-xl font-medium text-gray-900 text-center mt-4">Cursos que imparto</h2>
                </div>
                <div class="flex justify-center">
                    <v-table>
                        <thead>
                        <tr>
                            <th>Nombre del curso</th>
                            <th>Modalidad</th>
                            <th>Tipo de curso, taller, conferencias, etc: </th>
                            <th>Fechas en las que se realizara la actividad o evento: </th>
                            <th>Horarios en las que se realizara la actividad o evento: </th>
                            <th>FICHA TÉCNICA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="curso in props.docente.facilitador_has_deteccion">
                            <td>
                                {{curso.nombreCurso}}
                            </td>
                            <td>
                                <template v-if="curso.modalidad === 1">
                                    Virtual
                                </template>
                                <template v-if="curso.modalidad === 2">
                                    Presencial
                                </template>
                                <template v-if="curso.modalidad === 3">
                                    Hibrído
                                </template>
                            </td>
                            <td>
                                <template v-if="curso.tipo_actividad === 1">
                                    <span>TALLER</span>
                                </template>
                                <template v-if="curso.tipo_actividad === 2">
                                    <span>CURSO</span>
                                </template>
                                <template v-if="curso.tipo_actividad === 3">
                                    <span>CURSO-TALLER</span>
                                </template>
                                <template v-if="curso.tipo_actividad === 4">
                                    <span>FORO</span>
                                </template>
                                <template v-if="curso.tipo_actividad === 5">
                                    <span>SEMINARIO</span>
                                </template>
                            </td>
                            <td>{{curso.fecha_I}} al {{curso.fecha_F}}</td>
                            <td>{{curso.hora_I}} a {{curso.hora_F}}</td>
                            <td>
                                <NavLink :href="route('crear.ficha', [props.auth.user.docente_id, curso.id])">
                                    <v-btn color="blue-darken-1" >
                                        Crear
                                    </v-btn>
                                </NavLink>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
