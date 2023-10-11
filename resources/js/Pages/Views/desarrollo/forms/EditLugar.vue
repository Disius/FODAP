<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NavLink from "@/Components/NavLink.vue";


const form = useForm({
    nombreAula: ""
})
const props = defineProps({
    lugar: Object
});

onMounted(() => {
    if (!props.lugar){
        return form;
    }else{
        form.nombreAula = props.lugar.nombreAula
    }
})
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Carrera</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="mt-6 space-y-6" @submit.prevent="form.put(route('update.lugar', props.lugar.id))">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <InputLabel for="nombre_aula" value="Nombre del Aula"/>
                                    <v-text-field v-model="form.nombreAula"></v-text-field>
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


<style scoped>

</style>
