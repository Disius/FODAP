<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";
import {fi} from "vuetify/locale";
import {router, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const dialog = ref(false);
const search = ref("")
const color = ref("")
const message = ref("")
const snackbar = ref(false)
const timeout = ref(0)


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
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        },
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

const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 8000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};

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

<!--                <div class="grid grid-cols-2">-->
<!--                    <div class="flex justify-start mt-12">-->
<!--                        <v-file-input label="Ingresar CVU" variant="solo" @input="form.file = $event.target.files[0]"></v-file-input>-->
<!--                    </div>-->
<!--                    <div class="flex justify-center mt-12">-->
<!--                        <v-btn color="blue-darken-1" @click="upload_file" width="500" height="50">-->
<!--                            Subir-->
<!--                        </v-btn>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <template v-if="props.docente.cvu != null">-->
<!--                    <div class="flex justify-start mt-5">-->
<!--                        <v-btn color="blue-darken-1" width="500" @click="download_cvu_editado">DESCARGAR MI CVU</v-btn>-->
<!--                    </div>-->
<!--                </template>-->
            </div>
        </div>
        <div class="mt-5 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex justify-items-center mb-12">
                    <h2 class="text-xl font-medium text-gray-900 text-center">Cursos que impartidos</h2>
                </div>
                <div class="flex justify-center">
                    <v-virtual-scroll
                        :items="props.docente.facilitador_has_deteccion"
                        height="300"
                        item-height="50"
                        class="mt-4"

                    >
                        <template v-slot:default="{ item }">
                            <v-list-item>
                                <template v-slot:prepend>
                                  <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                      <template v-if="item.estado === 0">
                                          <v-chip variant="flat" color="warning" prepend-icon="$info">
                                              Curso por realizar
                                          </v-chip>
                                      </template>
                                      <template v-else-if="item.estado === 1">
                                          <v-chip variant="flat" color="success" prepend-icon="$info">
                                              En curso
                                          </v-chip>
                                      </template>
                                      <template v-else-if="item.estado === 2">
                                          <v-chip variant="flat" color="error" prepend-icon="mdi-cancel">
                                              Finalizado
                                          </v-chip>
                                      </template>
                                  </div>
                              </template>
                                <div class="ml-8">
                                    <v-list-item-title>{{ item.nombreCurso }}</v-list-item-title>
                                </div>
                                    <template v-slot:append>
                                        <NavLink :href="route('show.curso.facilitador', [props.docente.id, item.id,])" type="button" as="button">
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
                                    </template>
                            </v-list-item>
                        </template>
                    </v-virtual-scroll>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
