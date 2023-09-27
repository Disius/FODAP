<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import {fi} from "vuetify/locale";
import {useForm} from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
   auth: Object
});

const file = ref();

const download_cvu = () => {
    const url = '/storage/CVUdownload/CVUEditable.docx';
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'CVUEditable.docx');
    document.body.appendChild(link);
    link.click();
}

const upload_file = () => {
    return axios.get(route('upload.cvu'), {
        params: {
            file_name: file.value[0].name,
            file_size: file.value[0].size,
            id: props.auth.user.docente_id,
        }
    }).then(res => {
        console.log(res.data)
    }).catch(error => {
        console.log(error.response.data)
    })
    // console.log(file.value[0])
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
                <div class="flex justify-center w-100">
                    <v-btn block height="50" color="blue-darken-1" @click="download_cvu">Descargar CVU</v-btn>
                </div>
                <div class="flex justify-items-center mt-12">
                    <v-file-input v-model="file" label="Subir CVU" variant="solo" @change="upload_file"></v-file-input>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
