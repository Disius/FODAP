<script setup>
import {computed, ref} from "vue";

const props = defineProps({
    modelValue: {
        type: Boolean,
    },
    color: {
        type: String,
    },
    timeout: {
        type: Number,
    },
    message: {
        type: String,
    }
})

const emit = defineEmits([
    'update:modelValue'
])


</script>

<template>
    <v-snackbar vertical v-model="props.modelValue" :color="color" :timeout="timeout" bottom>
        <div class="text-subtitle-1 pb-2">{{message}}</div>
        <template v-slot:actions>
            <v-btn color="white" text @click="emit('update:modelValue', false)">Cerrar</v-btn>
        </template>
        <slot name="reloadingbutton"/>
        <slot name="mensaje"/>
    </v-snackbar>
</template>

<style scoped>

</style>
