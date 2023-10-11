<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo departamento</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="mt-6 space-y-6" @submit.prevent="form.post(route('store.departamento'))">
                    <v-card height="450" width="auto">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <InputLabel for="nombre_departamento" value="Nombre del departamento"/>
                                    <v-text-field v-model="form.nameDepartamento"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <InputLabel for="jefe_departamento" value="Jefe del departamento"/>
                                    <v-autocomplete v-model="form.jefe_id" :items="props.docente" item-title="nombre" item-value="id" variant="solo"></v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                    <InputLabel for="carrera_adscrita" value="Carrera(s) adscrita(s)"/>
                                    <v-select multiple v-model="form.carrera_id" :items="props.carrera" item-value="id" item-title="nameCarrera" variant="solo"></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                        <v-divider></v-divider>
                        <v-card-actions>
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
                        </v-card-actions>
                    </v-card>
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
    carrera_id: null,
    nameDepartamento: "",
    jefe_id: null,
})
const props = defineProps({
    carrera: {
        type: Array
    },
    docente: {
        type: Array
    },
    departamento: {
        type: Array
    }
});

onMounted(() => {

})
</script>

<style scoped>

</style>
