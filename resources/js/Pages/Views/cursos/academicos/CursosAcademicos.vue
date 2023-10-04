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



        <template v-if="props.cursos.length !== 0">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-3 sm:p-8 bg-white shadow sm:rounded-lg">
                    <TablaCursoAcademico :cursos="props.cursos" :user="props.auth"></TablaCursoAcademico>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                        color="blue-darken-1"
                        icon="mdi-alert-circle"
                        prominent
                    >
                        Actualmente no se han capturado cursos.
                    </v-alert>
                </div>
            </div>
        </template>

        <v-container class="mt-3">
            <v-row justify="center">
                <v-col cols="12" align="center">
                    <NavLink :href="route('index.registros')" :active="route().current('index.registros')" as="button">
                        <v-btn rounded="xl" block size="x-large" color="blue-darken-1" prepend-icon="mdi-archive">
                            Todos los registros
                        </v-btn>
                    </NavLink>
                </v-col>
            </v-row>
        </v-container>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
