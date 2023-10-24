<script setup>

import NavLink from "@/Components/NavLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
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
                                    class="block h-14 w-14 fill-current"
                                />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Instalador
                            </NavLink>
                        </div>
                    </div>


                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">

                            </div>
                        </div>
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">

                        </div>
                    </div>

                    <!-- Hamburger -->

                </div>
            </div>

            <!-- Responsive Navigation Menu -->
        </nav>
        <!-- Page Heading -->


        <main class="">
            <slot />
        </main>
    </div>
</template>

<style scoped>

</style>
