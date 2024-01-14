<script setup>
import {Link} from '@inertiajs/vue3'
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ApplicationLogoTecNM from "@/Components/ApplicationLogoTecNM.vue";
import ApplicationLogoEducacion from "@/Components/ApplicationLogoEducacion.vue";
</script>

<template>
    <div>
        <div class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link :href="route('main')">
                        <ApplicationLogo
                            class="block h-16 w-20 fill-current text-gray-800 mb-5"
                        />
                    </Link>
                </div>
                <div>
                    <Link :href="route('main')">
                        <ApplicationLogoTecNM
                            class="block h-20 w-40 fill-current text-gray-800 mb-5"
                        />
                    </Link>
                </div>
            </div>
        </div>
        <div class="relative h-screen">
            <!-- Main con el contenido -->
            <main class="absolute inset-0 flex items-center justify-center">
                <slot/>
            </main>
        </div>

        <footer class="bg-blue-900 text-white py-6">
            <div class="container mx-auto text-center">
                <div class="flex items-center space-x-4">
                    <ApplicationLogoEducacion
                        class="block h-20 w-40 fill-current text-gray-800 mb-5"
                    />
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>

</style>
