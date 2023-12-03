<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    director: {
        type: Array
    },
    modelValue: {
        type: Boolean
    }
});

const emit = defineEmits([
    'update:modelValue'
]);
</script>

<template>
    <v-table
        fixed-header
        height="120px"
        style="width: 500px;"
        hover
    >
        <thead>
        <tr>
            <th class="text-center">Nombre del(a) director(a)</th>
            <th class="text-center">Editar</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="d in props.director"
            :key="d.id"
        >
            <td class="text-center text-truncate">{{d.nameDirector}}</td>
            <td class="text-center">
                <primary-button @click="emit('update:modelValue', true)">
                    <v-icon>mdi-pencil</v-icon>
                </primary-button>
            </td>
        </tr>
        </tbody>
    </v-table>
</template>


<style scoped>

</style>
