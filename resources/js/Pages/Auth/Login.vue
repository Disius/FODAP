<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import {computed, onMounted, ref} from "vue";
import {FODAPStore} from "@/store/server.js";


const store = FODAPStore()
const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    role: {
        type: String
    },
    administrator: {
        type: String
    }
});
const alert = ref(false);
const transform_prop = computed(() => {
    return Boolean(props.administrator)
})
const form = useForm({
    email: '',
    password: '',
    remember: false,
});
const rol = computed(() =>{
    return parseInt(props.role);
})
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const email_rules = [
    v => {
        return /^[A-Za-z0-9._%+-]+@(tuxtla\.tecnm\.mx|tecnm\.mx)$/.test(v) || "Su email debe ser exclusivamente institucional"
    }
];

onMounted(() => {
    store.admin_get()
})
</script>

<template>
    <GuestLayout>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <template v-if="transform_prop === true">
            <div class="flex justify-end">
                <v-tooltip location="left">
                    <template v-slot:activator="{ props }">
                        <v-btn icon v-bind="props" color="blue-darken-1" size="normal" @click="alert = !alert">
                            <v-icon>
                                mdi-help
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Presionar para acceder a datos de inicio de sesión e iniciar la instalacion</span>
                </v-tooltip>
            </div>
            <div class="flex justify-center mt-3 mb-4">
                <v-alert
                    v-model="alert"
                    variant="tonal"
                    closable
                    close-label="Cerrar"
                    color="info"
                    title="Inicio de sesión"
                >
                    <p>Usuario: admin@tuxtla.tecnm.mx</p> <br> <p>Contraseña: admin123</p>
                </v-alert>
            </div>
        </template>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Correo Institucional" />

<!--                <TextInput-->
<!--                    id="email"-->
<!--                    type="email"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.email"-->
<!--                    required-->
<!--                    autofocus-->
<!--                    autocomplete="username"-->
<!--                />-->
                <v-text-field v-model="form.email" :rules="email_rules">

                </v-text-field>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    ¿Olvidaste tu contraseña?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar sesión
                </PrimaryButton>
            </div>
        </form>
        <template v-if="rol === 4">
            <div class="flex items-center justify-center mt-4">
                <Link :href="route('register')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :data="{role: $props.role}">
                    ¿No te encuentras registrado?
                </Link>
            </div>
        </template>
        <template v-if="props.role === 4">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex justify-center">
                    <v-btn append-icon="mid-microsoft">Iniciar sesión con Microsoft</v-btn>
                </div>
            </div>
        </template>
    </GuestLayout>
</template>
