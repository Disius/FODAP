<script setup>
import {useForm} from "@inertiajs/vue3";
import {onBeforeMount, onMounted} from "vue";
import axios from 'axios'


const props = defineProps({
    modelValue: Boolean,
    curso: Number,
})

const emit = defineEmits([
    'update:modelValue'
]);


const submitActa = () => {
    axios.get(route('pdf.acta.calificaciones'), {
            params: {
                id: props.curso
            }
    }).then(res => {
        const url = '/storage/acta_de_calificaciones.pdf';
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'acta_calificaciones.pdf');
        document.body.appendChild(link);
        link.click();
        emit('update:modelValue', false)
    }).catch(error => {
        console.log(error)
    })
}

onMounted(() => {
    if (props.modelValue === true){
        submit()
    }
})

onBeforeMount(() => {
    emit('update:modelValue', false)
})
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue">
        <v-fade-transition leave-absolute>
            <v-progress-circular
                v-if="props.modelValue"
                color="info"
                :size="64"
                :width="7"
                indeterminate
            ></v-progress-circular>
        </v-fade-transition>
    </v-dialog>
</template>

<style scoped>

</style>
