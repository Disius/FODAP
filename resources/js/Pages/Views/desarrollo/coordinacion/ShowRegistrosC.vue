<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const store = Curso()
const props = defineProps({
   cursos: Array,
    auth: Object
});
const search = ref("");
const setColor = (state) => {
    if (state === 0){
        return 'warning';
    }else {
        return 'success'
    }
}
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

    store.get_curso_desarrollo()
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de todos los cursos que se llevaron acabo</h2>
        </template>

        <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <template v-if="props.cursos.length !== 0">
                    <v-data-iterator
                        :items="props.cursos"
                        item-value="nombreCurso"
                        :search="search"
                    >
                        <template v-slot:header>
                            <v-text-field
                                v-model="search"
                                clearable
                                density="comfortable"
                                hide-details
                                placeholder="Buscar"
                                prepend-inner-icon="mdi-magnify"
                                style="max-width: 300px;"
                                variant="solo"
                            >

                            </v-text-field>
                        </template>
                        <template v-slot:default="{items}">
                            <v-container class="pa-2" fluid>
                                <v-row dense>
                                    <v-col v-for="item in items" :key="item.nameCarrera"
                                           cols="auto"
                                           md="4"
                                    >
                                        <v-card class="pb-3" border flat >
                                            <v-list-item class="mb-2" :subtitle="item.raw.asignaturaFA">
                                                <template v-slot:title>
                                                    <strong class="text-h6 mb-2">
                                                        {{item.raw.nombreCurso}}
                                                    </strong>
                                                </template>
                                            </v-list-item>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <template v-if="item.raw.tipo_FDoAP === 1">
                                                        <p class="text-truncate">Formación Docente</p>
                                                    </template>
                                                    <template v-if="item.raw.tipo_FDoAP === 2">
                                                        <p>Actualización Profesional</p>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <p class="text-truncate">Dirigido a la academica de {{item.raw.carrera.nameCarrera}}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-space-between px-4">
                                                <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                                    <template v-if="item.raw.estado === 0">
                                                        <strong class="text-truncate">Curso por realizar</strong>
                                                    </template>
                                                    <template v-else>
                                                        <strong class="text-truncate">En curso</strong>
                                                    </template>
                                                </div>
                                                <NavLink :href="route('index.desarrollo.inscritos', item.raw.id)" type="button" as="button">
                                                    <v-btn
                                                        border
                                                        flat
                                                        size="small"
                                                        class="text-none"
                                                        text="Ver"
                                                        prepend-icon="mdi-eye-arrow-right-outline"
                                                    >
                                                    </v-btn>
                                                </NavLink>
                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </template>
                    </v-data-iterator>
                </template>
                <template v-else>
                    <div class="mt-2 mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg">
                            <v-alert
                                color="blue-darken-1"
                                icon="mdi-alert-circle"
                                prominent
                            >
                                Actualmente no hay cursos por realizarse, puede visualizar todos los que se llevaron acabo al presionar  "Ver todos los registros".
                            </v-alert>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>



</style>
