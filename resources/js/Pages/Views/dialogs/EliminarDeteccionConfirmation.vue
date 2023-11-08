<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import {computed, onMounted, ref} from "vue";
import {Curso} from "@/store/curso.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const store = Curso()
const snackSuccess = ref(false);
const snackError = ref(false);
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

const submit = () => {
    loading.value = true;
    form.delete(route('delete.deteccion', props.curso), {
        onSuccess: () => {
            loading.value = false;
            emit('update:modelValue', false)
        },
        onError: () => {
            loading.value = false;
        },
    })
}
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue" persistent>
        <v-card width="500" height="200">
            <v-card-title class="text-center mt-8 mb-10">¿Esta seguro que desea eliminar este curso?</v-card-title>
            <v-dialog width="auto" v-model="loading">
                <v-fade-transition leave-absolute>
                    <v-progress-circular
                        v-if="loading"
                        color="info"
                        :size="64"
                        :width="7"
                        indeterminate
                    ></v-progress-circular>
                </v-fade-transition>
            </v-dialog>
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
    <v-snackbar
        v-model="snackSuccess"
        vertical
    >
        <div class="text-subtitle-1 pb-2">Exito</div>

        <p>Se ha eliminado el curso correctamente</p>

        <template v-slot:actions>
            <v-btn
                color="indigo"
                variant="text"
                @click="snackSuccess = false"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
    <v-snackbar
        v-model="snackError"
        vertical
    >
        <div class="text-subtitle-1 pb-2">Error</div>

        <p>No se ha eliminado el curso correctamente</p>

        <template v-slot:actions>
            <v-btn
                color="indigo"
                variant="text"
                @click="snackError = false"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
</template>

<style scoped>

</style>
