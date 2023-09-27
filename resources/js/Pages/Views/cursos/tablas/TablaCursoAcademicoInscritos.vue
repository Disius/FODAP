<script setup>
import NavLink from "@/Components/NavLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    curso: Object,
    user: Object
})

// const submit = (inscripcion, id) => {
//     axios.get(route('cdi.pdf'), {
//         params: {
//             docente: inscripcion,
//             id_curso: id
//         }
//     }).then(res => {
//         const url = '/storage/CDI.pdf';
//         const link = document.createElement('a');
//         link.href = url;
//         link.setAttribute('download', 'CDI.pdf');
//         document.body.appendChild(link);
//         link.click();
//         console.log(res.data)
//     }).catch(error => {
//         console.log(error.response.data)
//         snackbar.value = true
//     })
// }

</script>

<template>
   <v-table fixed-header height="500px" hover>
        <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido Paterno</th>
                <th class="text-center">Apellido Materno</th>
<!--                <th class="text-center">Cédula de Inscripcion</th>-->
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="inscrito in props.curso.docente_inscrito"
                :key="inscrito.id"

            >
                <td class="text-center">{{inscrito.nombre}}</td>
                <td class="text-center">{{inscrito.apellidoPat}}</td>
                <td class="text-center">{{inscrito.apellidoMat}}</td>
<!--                <td class="text-center">-->
<!--                    <div class="flex justify-center items-center">-->
<!--                        <v-btn prepend-icon="mdi-file-pdf-box" color="blue-darken-1" @click="submit(inscrito.id, props.curso.id)">-->
<!--                            GENERAR PDF-->
<!--                        </v-btn>-->
<!--                    </div>-->
<!--                </td>-->
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
