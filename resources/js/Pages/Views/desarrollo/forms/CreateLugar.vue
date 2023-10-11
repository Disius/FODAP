<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NavLink from "@/Components/NavLink.vue";


const form = useForm({
    nombreAula: ""
})
const props = defineProps({

});

onMounted(() => {

})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Aula</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="mt-6 space-y-6" @submit.prevent="form.post(route('store.lugar'))">
                    <v-card height="250" width="auto">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <InputLabel for="nombre_aula" value="Nombre del Aula"/>
                                    <v-text-field class="mt-8" v-model="form.nombreAula"></v-text-field>
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

<style scoped>

</style>
