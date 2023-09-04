<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCursoDocente from "@/Pages/Views/cursos/tablas/TablaCursoDocente.vue"
import {computed, onMounted, ref} from "vue";
import TablaCursoAcademico from "@/Pages/Views/cursos/tablas/TablaCursoAcademico.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogPIFAP from "@/Pages/Views/dialogs/DialogPIFAP.vue";
import DeteccionDialog from "@/Pages/Views/dialogs/DeteccionDialogPDF.vue";

const props = defineProps({
    cursos: Array,
    auth: Object,
    curso_estado: Array
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
    })
});
</script>

<template>
    <Head title="Cursos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>


        <v-container>
            <v-row justify="end">
                <v-col cols="12">
                    <v-btn prepend-icon="mdi-file-pdf-box" size="large" @click="pdf_dialog = true" color="blue-darken-1">
                        Generar PIFDAP
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <DialogPIFAP v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DialogPIFAP>

        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-3 sm:p-8 bg-white shadow sm:rounded-lg">
                <TablaCursoAcademico :cursos="props.cursos" :user="props.auth" :curso_estado="props.curso_estado"></TablaCursoAcademico>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
