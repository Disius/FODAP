<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    sub: {
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
        hover
    >
        <thead>
        <tr>
            <th class="text-center">Nombre del(a) subdirector(a)</th>
            <th class="text-center">Editar</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="s in props.sub"
            :key="s.id"
        >
            <td class="text-center">{{s.name}}</td>
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
