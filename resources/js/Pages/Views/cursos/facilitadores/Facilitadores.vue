<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";
import {fi} from "vuetify/locale";
import {router, useForm} from "@inertiajs/vue3";


const dialog = ref(false);
const search = ref("")

const props = defineProps({
   auth: Object,
   docente: Object
});


const form = useForm({
    file: null,
    id: props.auth.user.docente_id
});


const download_cvu = () => {
    const url = '/storage/CVUdownload/CVU_editable.docx';
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'CVUEditable.docx');
    document.body.appendChild(link);
    link.click();
}

const upload_file = () => {
    form.post(route('upload.cvu'), {
        forceFormData: true,
        onSuccess: () => {

        }
    })
}

const download_cvu_editado = () => {
    let url = '/storage' + '/' + props.docente.cvu.path
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'CVU_'+ props.docente.id + '.pdf');
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
                <template v-if="props.docente.cvu === null">
                    <div class="flex justify-center w-50">
                        <v-btn block height="50" color="blue-darken-1" @click="download_cvu">Descargar para editar</v-btn>
                    </div>

                    <div class="grid grid-cols-2">
                        <div class="flex justify-start mt-12">
                            <v-file-input label="Ingresar CVU" variant="solo" @input="form.file = $event.target.files[0]"></v-file-input>
                        </div>
                        <div class="flex justify-center mt-12">
                            <v-btn color="blue-darken-1" @click="upload_file" width="500" height="50">
                                Subir
                            </v-btn>
                        </div>
                    </div>
                </template>
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
                    <h2 class="text-xl font-medium text-gray-900 text-center">Cursos que impartidos</h2>
                </div>
                <div class="flex justify-center">
                    <v-data-iterator
                        :items="props.docente.facilitador_has_deteccion"
                        item-value="nombreCurso"
                        class="pa-4"
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
                            <v-container class="pa-8" fluid>
                                <v-row dense>
                                    <v-col v-for="item in items" :key="item.nombreCurso"
                                           cols="auto"
                                           md="4"
                                    >
                                        <v-card class="pb-3" border flat >
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

                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <template v-if="item.raw.estado === 0">
                                                        <v-chip color="info" prepend-icon="mdi-information">Curso por realizar</v-chip>
                                                    </template>
                                                    <template v-if="item.raw.estado === 1">
                                                        <v-chip class="text-truncate" color="success" prepend-icon="mdi-check-circle">En curso</v-chip>
                                                    </template>
                                                    <template v-if="item.raw.estado === 2">
                                                        <v-chip class="text-truncate" color="error" prepend-icon="mdi-cancel">Finalizado</v-chip>
                                                    </template>
                                                </div>
                                                <NavLink :href="route('show.curso.facilitador', [props.auth.user.docente_id, item.raw.id])" as="button">
                                                    <v-btn icon="mdi-eye" color="blue-darken-1" >

                                                    </v-btn>
                                                </NavLink>
                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </template>
                    </v-data-iterator>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
