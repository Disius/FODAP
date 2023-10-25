<script setup>
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {ref, computed, watch, onMounted} from 'vue';
import axios from "axios";
const props = defineProps({
    modelValue: Boolean,
    auth: Object,
    curso: Object
});


const emit = defineEmits([
    'update:modelValue'
]);

const form = useForm({
    id: props.auth.user.docente_id,
    file: null,
    id_facilitador: props.auth.user.id
})

const upload_file_ft = () => {
    form.post(route('upload.ficha'), {
        forceFormData: true
    });
}


</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue" persistent>
        <v-card width="600" height="300">
            <v-card-title class="text-center">
                FICHA TÉCNICA
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row justify="center">
                        <v-col cols="12">
                            <div class="d-flex justify-center mt-6">
                                <v-file-input label="Subir archivo" variant="solo" @input="form.file = $event.target.files[0]"></v-file-input>
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-container>
                   <v-row justify="center">
                       <v-col cols="6">
                           <div class="d-flex justify-end">
                               <v-btn align="center" color="error" @click="emit('update:modelValue', false)">
                                   Cerrar
                               </v-btn>
                           </div>
                       </v-col>
                       <v-col cols="6">
                           <div class="d-flex justify-center">
                               <v-btn color="blue-darken-1" @click="upload_file_ft">
                                   Subir
                               </v-btn>
                           </div>
                       </v-col>
                   </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
