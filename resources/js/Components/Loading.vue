<script setup>

const props = defineProps({
    loading: Boolean,
})
const emit = defineEmits([
    'update:loading',
])
</script>

<template>
    <v-dialog width="auto" v-model="props.loading">
        <slot></slot>
    </v-dialog>
</template>

<style scoped>

</style>
