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
    errors: Object
});

const pdf_dialog = ref(false);



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
            <v-container class="mx-auto">
                <v-row justify="center">
                    <v-col cols="7" align="center">
                        <v-btn @click="pdf_dialog = true" prepend-icon="mdi-file-pdf-box" color="blue-darken-1" rounded="xl" block width="200" height="50">
                            Generar PDF
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
            <template v-if="props.detecciones.length === 0">
                <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                        <v-alert
                            color="blue-darken-1"
                            icon="mdi-alert-circle"
                            prominent
                        >
                            Actualmente no se han capturado deteccion de necesidades.
                        </v-alert>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-4">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <TablaDetecciones :detecciones="props.detecciones"></TablaDetecciones>
                    </div>
                </div>
            </template>
        </div>
<!--        <v-row justify="center" class="mt-2">-->
<!--            <v-col cols="2">-->
<!--                <NavLink :href="route('index.registros.c')" as="button">-->
<!--                    <v-btn rounded="xl" block size="large" color="blue-darken-1">-->
<!--                        Ver todos los registros-->
<!--                    </v-btn>-->
<!--                </NavLink>-->
<!--            </v-col>-->
<!--        </v-row>-->
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
