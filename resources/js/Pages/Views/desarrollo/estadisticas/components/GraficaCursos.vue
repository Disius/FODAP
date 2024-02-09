<script setup>
import {Bar} from "vue-chartjs";
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from "chart.js";

const props = defineProps({
    cursos_anio: Number,
    cursos_periodos: Array
})

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

</script>

<template>

</template>

<style scoped>

</style>
