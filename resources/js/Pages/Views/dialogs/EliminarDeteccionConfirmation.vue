<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import {computed, onMounted, ref} from "vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import Loading from "@/Components/Loading.vue";

const store = Curso()
const snack = ref(false);
const message = ref()
const color = ref()
const timeout = ref()
const props = defineProps({
    modelValue: Boolean,
    curso: Number,
});

const form = useForm({
    curso_id: props.curso
})

const loading = ref(false);

const emit = defineEmits([
    'update:modelValue'
]);
function snackSuccess(){
    message.value = 'Recurso Eliminado con exito'
    color.value = 'success'
    timeout.value = 2000
    snack.value = true
    setTimeout(() => {
        snack.value = false
    }, timeout.value)
}
function snackError(){
    message.value = 'El recurso no se pudo eliminar'
    color.value = 'error'
    timeout.value = 2000
    snack.value = true
    setTimeout(() => {
        snack.value = false
    }, timeout.value)
}
const submit = () => {
    loading.value = true;
    form.delete(route('delete.deteccion.desarrollo', props.curso), {
        onSuccess: () => {
            loading.value = false;
            snackSuccess()
            emit('update:modelValue', false)
        },
        onError: () => {
            snackError()
            loading.value = false;
        },
    })
}
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue" persistent>
        <v-card width="500" height="200">
            <v-card-title class="text-center mt-8 mb-10">¿Esta seguro que desea eliminar este curso?</v-card-title>
            <v-card-actions>
                <v-row justify="center" no-gutters>
                    <v-col cols="6" align="center" class="">
                        <primary-button elevation="5" color="error" @click="emit('update:modelValue', false)">
                            Cerrar
                        </primary-button>
                    </v-col>
                    <v-col cols="2" align="center" class="mr-16">
                        <danger-button elevation="5" color="success" @click="submit" class="">
                            Eliminar
                        </danger-button>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <CustomSnackBar
        :color="color"
        :timeout="timeout"
        :message="message"
        v-model="snack"
        @update:modelValue="snack = $event"
    ></CustomSnackBar>
    <Loading
    v-model="loading"
    @update:loading="loading = $event"

    >
        <v-fade-transition leave-absolute>
            <v-progress-circular
                v-if="loading"
                color="info"
                :size="64"
                :width="7"
                indeterminate
            ></v-progress-circular>
        </v-fade-transition>
    </Loading>
</template>

<style scoped>

</style>
