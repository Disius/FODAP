<script setup>
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ApplicationLogoTecNM from "@/Components/ApplicationLogoTecNM.vue";
import ApplicationLogoEducacion from "@/Components/ApplicationLogoEducacion.vue";
</script>

<template>
    <div class="h-screen flex flex-col">
        <nav
            class="fixed w-full bg-white py-2 shadow-xl dark:bg-body-dark z-20"
        >
            <div
                class="container mx-auto px-4 py-6 flex items-center justify-between"
            >
                <div class="flex items-center space-x-4">
                    <Link :href="route('main')">
                        <ApplicationLogo
                            class="block h-16 w-28 fill-current text-gray-800 mb-5"
                        />
                    </Link>
                </div>
                <div>
                    <Link :href="route('main')">
                        <ApplicationLogoTecNM
                            class="block h-16 w-28 fill-current text-gray-800 mb-5"
                        />
                    </Link>
                </div>
            </div>
        </nav>
        <main class="mt-15">
            <slot />
        </main>

        <footer class="py-6">
            <div class="container mx-auto text-center">
                <div class="flex justify-center items-center space-x-4">
                    <ApplicationLogoEducacion
                        class="block h-16 w-28 fill-current text-gray-800 mb-5"
                    />
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped></style>
