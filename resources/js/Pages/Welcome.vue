<script setup>
import { Head, Link } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const nameCards = ref([
    { flex: 5, name: "Departamento de Desarrollo Académico", user_rol: 1, route: "/login"},
    { flex: 5, name: "Coordinación de Formación docente y Actualización profesional", user_rol: 2, route: "/login",},
    { flex: 5, name: "Jefes Academicos", user_rol: 3, route: "/login" },
    { flex: 5, name: "Docentes", user_rol: 4, route: "/login" },
]);
</script>

<template>
    <Head title="Welcome" />



    <div
        class="relative sm:flex sm:justify-center mt-8"
    >
        <v-row justify="center" class="mt-12">
            <v-col
                v-for="card in nameCards"
                :key="card.name"
                :cols="card.flex"
                class="d-flex justify-center align-center md"
                md="5"
                sm="5"
                xs="5"
            >
                <Link :href="card.route"
                      as="card"
                      type="card"
                      :data="{ role: card.user_rol }">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                v-bind="props"
                                :color="isHovering ? 'light-blue-darken-4' : undefined"
                                height="250"
                                width="600"
                                class="d-flex justify-center align-center"
                                link
                                type="card"
                                elevation="10"
                            >
                                <span class="text-h6 text-center">{{card.name}}</span>
                            </v-card>
                        </template>
                    </v-hover>
                </Link>
            </v-col>
        </v-row>


    </div>
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
