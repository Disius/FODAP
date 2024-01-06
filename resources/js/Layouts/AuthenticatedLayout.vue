<script setup>
import {computed, onBeforeMount, onMounted, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import {FODAPStore} from "@/store/server.js";


const showingNavigationDropdown = ref(false);
const docente = computed(() => usePage().props.info[0]);
const user = computed(() => usePage().props.auth.user);
const store = FODAPStore()
const notificationObject = ref({});

onMounted(() => {
    window.Echo.private(`App.Models.User.${user.value.id}`).notification((notification) => {
        notificationObject.value = notification
    });
    store.get_is_facilitador(user.value.docente_id)
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-16 w-20 fill-current"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Tablero
                                </NavLink>
                                <template v-if="user.role === 1 || user.role === 2">
                                    <NavLink :href="route('parametros.edit')" :active="route().current('parametros.edit')">
                                        Configuración
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 1 || user.role === 2">
                                    <NavLink :href="route('index.docentes')" :active="route().current('index.docentes')">
                                        Docentes
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 3">
                                    <NavLink :href="route('detecciones.index')" :active="route().current('detecciones.index')">
                                        Deteccion de Necesidades
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 3">
                                    <NavLink :href="route('index.cursos.academicos')" :active="route().current('index.cursos.academicos')">
                                        Cursos
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 3">
                                    <NavLink :href="route('index.docentes.academicos')" :active="route().current('index.docentes.academicos')">
                                        Docentes
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 1 || user.role === 2">
                                    <v-tooltip text="Deteccion de Necesidades">
                                        <template v-slot:activator="{ props }">
                                            <!--                                                <v-btn v-bind="props">Tooltip</v-btn>-->
                                            <NavLink :href="route('index.detecciones')" :active="route().current('index.detecciones')" v-bind="props">
                                                DN
                                            </NavLink>
                                        </template>
                                    </v-tooltip>
                                </template>
                                <template v-if="user.role === 1 || user.role === 2">
                                    <NavLink :href="route('index.desarrollo.cursos')" :active="route().current('index.desarrollo.cursos')">
                                        Cursos
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 4">
                                    <NavLink :href="route('index.cursos.docentes')" :active="route().current('index.cursos.docentes')">
                                        Cursos
                                    </NavLink>
                                </template>
                                <template v-if="user.role === 4">
                                    <NavLink :href="route('index.misCursos')" :active="route().current('index.misCursos')">
                                        Mis Cursos
                                    </NavLink>
                                </template>
                                <template v-if="store.this_facilitador === true">
                                    <NavLink :href="route('show.facilitadores' , user.docente_id)" :active="route().current('show.facilitadores')">
                                        Facilitador
                                    </NavLink>
                                </template>
                                <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                                    Perfil
                                </NavLink>
                                <NavLink :href="route('logout')" method="post" :active="route().current('logout')">
                                    Cerrar Sesión
                                </NavLink>
                                <v-btn class="mt-4" elevation="0">
                                    <template v-if="docente[0] != null">
                                        {{ docente[0].nombre }}
                                    </template>
                                </v-btn>

                            </div>
                        </div>
<!--                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 sm:pl-16 sm:ml-16">-->
<!--                            <div class="flex justify-between h-16 sm:pl-16 sm:ml-16">-->
<!--                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:pl-16">-->
<!--                                    <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">Perfil</NavLink>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <v-badge
                                        color="red"
                                        :content="$page.props.auth.usernotifications"
                                    >
                                                <span class="inline-flex rounded-md">
                                                    <NavLink :href="route('index.notifications')" as="button">
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                        >
                                                            <v-icon icon="mdi-bell"></v-icon>
                                                        </button>
                                                    </NavLink>
                                                </span>
                                    </v-badge>
                                </div>
                            </div>
                            <!-- Settings Dropdown -->
<!--                            <div class="ml-3 relative">-->
<!--                                <Dropdown align="right" width="48">-->
<!--                                    <template #trigger>-->
<!--                                        <span class="inline-flex rounded-md">-->
<!--                                            <button-->
<!--                                                type="button"-->
<!--                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"-->
<!--                                            >-->


<!--                                                <svg-->
<!--                                                    class="ml-2 -mr-0.5 h-4 w-4"-->
<!--                                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                                    viewBox="0 0 20 20"-->
<!--                                                    fill="currentColor"-->
<!--                                                >-->
<!--                                                    <path-->
<!--                                                        fill-rule="evenodd"-->
<!--                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"-->
<!--                                                        clip-rule="evenodd"-->
<!--                                                    />-->
<!--                                                </svg>-->
<!--                                            </button>-->
<!--                                        </span>-->
<!--                                    </template>-->

<!--                                    <template #content>-->
<!--                                        <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>-->
<!--                                        <DropdownLink :href="route('logout')" method="post" as="button">-->
<!--                                            Cerrar Sesión-->
<!--                                        </DropdownLink>-->
<!--                                    </template>-->
<!--                                </Dropdown>-->
<!--                            </div>-->
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Perfil </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Cerrar Sesión
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow w-full pt-16" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="">
                <slot />
            </main>
        </div>
    </div>
</template>
