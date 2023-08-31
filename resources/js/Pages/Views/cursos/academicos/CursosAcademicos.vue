<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablaCursoDocente from "@/Pages/Views/cursos/tablas/TablaCursoDocente.vue"
import {computed, onMounted, ref} from "vue";
import TablaCursoAcademico from "@/Pages/Views/cursos/tablas/TablaCursoAcademico.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogPIFAP from "@/Pages/Views/cursos/academicos/dialogs/DialogPIFAP.vue";
import DeteccionDialog from "@/Pages/Views/academicos/dialogs/DeteccionDialog.PDF.vue";

const props = defineProps({
    cursos: Array,
    auth: Object
});

const pdf_dialog = ref(false);

const menu = [
    {
        name: "Generar PROGRAMA INSTITUCIONAL DE FORMACIÓN DOCENTE\n" +
            "INSTITUTO TECNOLÓGICO DE TUXTLA GUTIERREZ"
    }
];

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
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn v-bind="props" size="x-large">
                                Documentos
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item
                                v-for="(item, index) in menu"
                                :key="item.id"
                                :value="item.id"
                                link
                            >
                                <v-list-item-title @click="pdf_dialog = true">{{ item.name }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
            </v-row>
        </v-container>
        <DialogPIFAP v-model="pdf_dialog" @update:modelValue="pdf_dialog = $event"></DialogPIFAP>

        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-3 sm:p-8 bg-white shadow sm:rounded-lg">
                <TablaCursoAcademico :cursos="props.cursos" :user="props.auth"></TablaCursoAcademico>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
