<script setup>
import {Link} from '@inertiajs/vue3'
</script>

<template>
    <div>
        <div class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
<!--                    <Link :href="route('main')">-->
<!--                        <ApplicationLogo-->
<!--                            class="block h-16 w-32 fill-current text-gray-800 mb-5"-->
<!--                        />-->
<!--                    </Link>-->
                    <nav class="space-x-4">
                        <slot name="quienesomos"/>
                        <Link href="#" class="text-gray-600 hover:text-gray-900 transition duration-300 text-lg"></Link>
                        <Link href="#" class="text-gray-600 hover:text-gray-900 transition duration-300 text-lg"></Link>
                        <Link href="#" class="text-gray-600 hover:text-gray-900 transition duration-300 text-lg"></Link>
                        <!-- Agrega más elementos del menú -->
                    </nav>
                </div>
                <div>
<!--                    <Link :href="route('login')" as="button">-->
<!--                        <button class="bg-red-500 text-white px-4 py-2 rounded shadow-md hover:bg-red-500 transition duration-300">INICIAR SESIÓN</button>-->
<!--                    </Link>-->
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
<!--                <p>&copy; {{year}} CORPORATIVO NAERCRIS S.A. DE C.V. Todos los derechos reservados.</p>-->
            </div>
        </footer>
    </div>
</template>

<style scoped>

</style>
