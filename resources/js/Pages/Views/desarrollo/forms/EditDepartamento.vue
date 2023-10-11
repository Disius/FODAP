<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Departamento</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="mt-6 space-y-6" @submit.prevent="form.put(route('update.departamento', props.departamento.id))">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <InputLabel for="nombre_departamento" value="Nombre del departamento"/>
                                    <v-text-field v-model="form.nameDepartamento"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <InputLabel for="jefe_id" value="Jefe del departamento"/>
                                    <v-autocomplete v-model="form.jefe_id" :items="props.docente" item-title="nombre_completo" item-value="id" variant="solo"></v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-container>
                        <v-divider></v-divider>
                        <v-row class="justify-end">
                            <v-col cols="2">
                                <NavLink :href="route('parametros.edit')">
                                    <DangerButton>Cancelar</DangerButton>
                                </NavLink>
                            </v-col>
                            <v-col cols="2">
                                <PrimaryButton>Guardar</PrimaryButton>
                            </v-col>
                        </v-row>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NavLink from "@/Components/NavLink.vue";


const form = useForm({
    nameDepartamento: "",
    jefe_id: null
})
const props = defineProps({
    carrera: {
        type: Array
    },
    docente: {
        type: Array
    },
    departamento: {
        type: Object
    }
});

onMounted(() => {
    if (!props.departamento){
        return form;
    }else{
            form.nameDepartamento = props.departamento.nameDepartamento
            form.jefe_id = props.departamento.jefe_id
    }
})
</script>

<style scoped>

</style>
