<script setup>
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import DangerButton from "@/Components/DangerButton.vue";
const props = defineProps({
    modelValue: Boolean,
    auth: Object,
});


const emit = defineEmits([
    'update:modelValue'
]);


</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue" persistent>
        <v-card width="600" height="100">
            <v-card-text>
                ¿Desea capturar otro curso?
            </v-card-text>
            <v-card-actions>
                <v-row justify="center">
                    <v-col cols="6">
                        <nav-link :href="route('detecciones.index')" as="button">
                            <danger-button color="error" size="normal" block>No</danger-button>
                        </nav-link>
                    </v-col>
                    <v-col cols="6">
                        <primary-button color="success" size="normal" block @click="emit('update:modelValue', false)">Si</primary-button>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
