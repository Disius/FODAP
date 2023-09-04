<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
const props = defineProps({
    modelValue: Boolean,
    docente: Array,
    curso: Object,
});

const teacherSelected = ref([]);
const search = ref("");
const emit = defineEmits([
    'update:modelValue'
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
        form.post(route('inscribir.docente', props.curso.id))
    }else{
        form.hasErrors
    }
}

function submit(){

    form.post(route('inscribir.docente', props.curso.id));
    form.reset();
}


</script>

<template>
<v-dialog width="auto" v-model="props.modelValue" persistent>
    <v-card width="600" height="500">
        <v-card-title class="text-center">Inscribir Docentes</v-card-title>
        <v-card-text>
            <v-text-field label="Buscar" v-model="search" class="mt-4"></v-text-field>
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
                <v-col cols="12">
                    <v-btn color="error" block @click="emit('update:modelValue', false)">
                        Cancelar
                    </v-btn>
                </v-col>
                <!-- <v-col cols="3">
                    <v-btn color="success" flat @click="addTeachers">
                        Agregar
                    </v-btn>
                </v-col> -->
            </v-row>
        </v-card-actions>
    </v-card>
</v-dialog>
</template>