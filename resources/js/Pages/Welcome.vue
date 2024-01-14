<script setup>
import { Link } from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import WelcomeLayout from "@/Layouts/WelcomeLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    can_install: {
        type: Boolean,
    }
});

const nameCards = ref([
    { flex: 4, name: "Departamento de Desarrollo Académico", user_rol: 1},
    { flex: 4, name: "Jefes Academicos", user_rol: 3 },
    { flex: 4, name: "Docentes", user_rol: 4 },
]);

onMounted(() => {

})
</script>

<template>
    <WelcomeLayout>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="(card, index) in nameCards" :key="index" class="p-6 bg-white rounded-md shadow-md">
                <h2 class="text-xl font-semibold mb-2 text-center">{{ card.name }}</h2>
<!--                <p class="text-gray-700">{{ card.description }}</p>-->
<!--                <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Ver Detalles</button>-->
            </div>
        </div>
    </WelcomeLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
