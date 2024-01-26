<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import {FODAPStore} from "@/store/server.js";
import {Curso} from "@/store/curso.js";

const my_curso_store = Curso()
const store = FODAPStore()


const props = defineProps({
    modelValue: Boolean,
    docente: Array,
    curso: Object,
    auth: Object,
    errors: Object,
});


const teacherSelected = ref([]);
const search = ref("");
const snackbar = ref(false);
const timeout = ref(4000);

const emit = defineEmits([
    'update:modelValue',
    'custom:snackbar'
]);

const form = useForm({
    id_docente: [],
});

const filterData = computed(() => {
    const busqueda = search.value.toLowerCase().trim();

    return props.docente.filter(item => {
        return item.nombre.toLowerCase().includes(busqueda) ||
        item.apellidoPat.toLowerCase().includes(busqueda) ||
        item.apellidoMat.toLowerCase().includes(busqueda) ||
        item.nombre_completo.toLowerCase().includes(busqueda)
    });

});
function addTeachers(teacher){
    if(!form.id_docente.includes(teacher)){
        form.id_docente.push(teacher.id)
        if (props.auth.role === 1 || props.auth.role === 2){
            form.post(route('inscribir.docente', props.curso.id), {
                onSuccess: () => {
                    form.reset()
                },
                onError: () => {
                    emit('custom:snackbar', true)
                    form.reset()
                },
            })
        }else if (props.auth.role === 3){
            form.post(route('inscripcion.academico', props.curso.id), {
                onSuccess: () => {
                    form.reset()
                },
                onError: () => {
                    emit('custom:snackbar', true)
                    form.reset()
                }
            })
        }
    }
}



</script>

<template>
<v-dialog width="auto" v-model="props.modelValue">
    <v-card width="700" height="700">
        <v-row justify="center">
            <v-col cols="2" align="start">
                <v-btn elevation="0" size="large" icon @click="emit('update:modelValue', false)">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-col>
            <v-col cols="10" align="start">
                <v-card-title class="text-center">Inscribir Docentes</v-card-title>
            </v-col>
        </v-row>
        <v-card-text>
            <v-text-field variant="solo" label="Buscar" v-model="search" class="mt-4"></v-text-field>
            <!-- <v-autocomplete multiple variant="solo" :items="props.docente" item-title="nombre_completo" item-value="id" v-model="teacherSelected"></v-autocomplete> -->
            <v-table>
                <thead>
                <tr>
                    <th class="text-left">
                        Nombre
                    </th>
                    <th class="text-left">

                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="docente in filterData"
                    :key="docente.id"
                >
                    <td>{{ docente.nombre_completo }}</td>
                    <td>
                        <primary-button @click="addTeachers(docente)">Inscribir</primary-button>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </v-card-text>
        <v-card-actions>
            <v-row justify="end">

            </v-row>
        </v-card-actions>
    </v-card>
</v-dialog>
</template>
