<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    modelValue: Boolean,
    curso: Number,
    docente: Number,
});

const form = useForm({
    calificacion: "",
    docente_id: props.docente,
    curso_id: props.curso
})

const loading = ref(false);

const emit = defineEmits([
    'update:modelValue'
]);

const submit = () => {
    loading.value = true;
    form.post(route('calificaciones.post'), {
        onSuccess: () => {
            loading.value = false
            form.reset();
        }
    })
}
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue">
        <v-card width="500" height="500">
            <v-card-title>Añadir calificación</v-card-title>
            <v-card-text>
                <v-row justify="center">
                    <v-col cols="12">
                        <InputLabel for="calificacion"
                                    value="Indicar si es APROBATORIO o NA (No acreditado)" />
                    </v-col>
                    <v-col cols="10" class="mt-16">
                        <v-text-field variant="solo-filled" v-model="form.calificacion"></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
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
                <v-row justify="center">
                    <v-col cols="6" align="end" class="mr-16">
                        <v-btn elevation="5" color="error" @click="emit('update:modelValue', false)">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="2" align="end" class="mr-16">
                        <v-btn elevation="5" color="success" @click="submit">
                            Subir
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
