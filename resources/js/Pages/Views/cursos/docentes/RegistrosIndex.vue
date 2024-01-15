<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    cursos: Object,
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos Finalizados</h2>
        </template>


        <template v-if="props.cursos !== null">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-table fixed-header height="500px" hover>
                            <thead>
                                <tr>
                                    <th class="text-left">Nombre de los
                                        Cursos</th>
                                    <th class="text-left">Objetivo</th>
                                    <th class="text-left">Fecha de
                                        realización</th>
                                    <th class="text-left">Lugar
                                        (presencial
                                        o virtual)
                                    </th>
                                    <th class="text-left">Horario
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="curso in props.cursos.inscrito"
                                    :key="curso.id"

                                >
                                    <td>
                                        {{curso.nombreCurso}}
                                    </td>
                                    <td>
                                        {{curso.objetivoEvento}}
                                    </td>
                                    <td>
                                        {{curso.fecha_I}} a {{curso.fecha_F}}
                                    </td>
                                    <td>
                                        <td class="v-card--hover">
                                            <template v-if="curso.modalidad === 1">
                                                <span>Virtual</span>
                                            </template>
                                            <template v-if="curso.modalidad === 2">
                                                <span>Presencial</span>
                                            </template>
                                            <template v-if="curso.modalidad === 3">
                                                <span>Hibrído</span>
                                            </template>
                                        </td>
                                    </td>
                                    <td>
                                        {{curso.hora_I}} a {{curso.hora_F}}
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                    border="start"
                    color="info"
                    type="info"
                    title="Cursos"
                    >
                        <h2>!Pronto deberias visualizar los cursos!</h2>
                    </v-alert>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style></style>
