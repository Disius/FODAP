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
        <v-fade-transition leave-absolute>
            <v-progress-circular
                v-if="props.loading"
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
