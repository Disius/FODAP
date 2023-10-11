<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Área Academica</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="mt-6 space-y-6" @submit.prevent="form.post(route('store.carrera'))">
                    <v-card height="450" width="auto">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <InputLabel for="nombre_carrera" value="Nombre del área"/>
                                    <v-text-field v-model="form.nameCarrera"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <InputLabel for="presidente_academia" value="Presidente de la academia"/>
                                    <v-autocomplete variant="solo" v-model="form.presidente_academia" :items="props.docente" item-title="nombre_completo" item-value="id"></v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                    <InputLabel for="presidente_academia" value="Departamento al que pertenece"/>
                                    <v-select v-model="form.departamento_id" :items="props.departamento" item-value="id" item-title="nameDepartamento" variant="solo"></v-select>
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
    departamento_id: null,
    nameCarrera: "",
    presidente_academia: null
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
