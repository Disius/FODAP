<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaDetecciones from "@/Pages/Views/desarrollo/tablas/TablaDetecciones.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed, onMounted, ref} from "vue";
import DeteccionDialog from '/resources/js/Pages/Views/dialogs/DeteccionDialogPDF.vue'
import axios from "axios";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    detecciones: Array,
    auth: Object,
    carrera: Array,
});

const pdf_dialog = ref(false);

const detecciones = ref([]);



onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    });




});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deteccion de Necesidades</h2>
        </template>

        <DeteccionDialog :carreras="props.carrera" v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DeteccionDialog>

        <div class="py-4">
            <v-container>
                <v-row>
                    <v-col>
                        <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl">
                            Generar Deteccion de Necesidades
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <TablaDetecciones :detecciones="props.detecciones"></TablaDetecciones>
                </div>
            </div>
        </div>
        <v-row justify="center" class="mt-2">
            <v-col cols="2">
                <NavLink :href="route('index.registros.c')" as="button">
                    <v-btn rounded="xl" block size="large" color="blue-darken-1">
                        Ver todos los registros
                    </v-btn>
                </NavLink>
            </v-col>
        </v-row>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
