<script setup>

const props = defineProps({
    modelValue: Boolean,
    cardWidth: {
        type: Number
    },
    cardHeight: {
        type: Number
    },
    item: Number,
})

const emit = defineEmits([
    'update:modelValue',
    'delete:item'
])

function closeDialog() {
    emit('update:modelValue', false);
}
function confirmAction() {
    emit('delete:item', props.item)
}
</script>

<template>
    <v-dialog width="auto" v-model="props.modelValue">
        <v-card :width="props.cardWidth" :height="props.cardHeight">
            <v-card-title class="text-center mt-8 mb-10">
                <slot name="title"></slot>
            </v-card-title>
            <v-card-text>
                <slot></slot>
            </v-card-text>
            <v-card-actions>
                <v-row justify="center" no-gutters>
                    <v-col cols="6" align="center">
                        <v-btn prepend-icon="mdi-cancel" color="blue-darken-1" @click="closeDialog">
                            <slot name="cancelText"></slot>
                        </v-btn>
                    </v-col>
                    <v-col cols="6" align="center">
                        <v-btn color="error" prepend-icon="mdi-delete-forever" @click="confirmAction">
                            Eliminar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
