<script setup>
import { Link } from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";

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
    <v-container class="pt-5">
        <v-row justify="center" class="pt-9 mt-9">
            <v-col
            v-for="card in nameCards"
            :cols="card.flex"
            class="mt-12 pt-12"
            lg="6"
            md="7"
            sm="8"
            xs="8"
            xl="4"
            >
                <Link :href="route('login')"
                      as="card"
                      type="card"
                      :data="{ role: card.user_rol }">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card
                                v-bind="props"
                                :color="isHovering ? 'light-blue-darken-4' : undefined"
                                height="250"
                                width="500"
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
    </v-container>
    <template v-if="can_install">
        <div class="grid grid-cols-2">
            <div class="flex justify-center mt-10 ml-16">
                <v-alert
                    color="info"
                    icon="$info"
                >
                    <p class="text-xl">Presiona instalar antes de iniciar sesión o usar el sistema</p>
                </v-alert>
            </div>
            <div class="flex justify-start ml-10 mt-10">
                <NavLink :href="route('login')" as="button" :data="{ administrator: true }">
                    <v-btn size="x-large" color="info">
                        Instalar
                    </v-btn>
                </NavLink>
            </div>
        </div>
    </template>
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
