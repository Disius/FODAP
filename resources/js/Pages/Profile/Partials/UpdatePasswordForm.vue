<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {ref, watch} from 'vue';
import zxcvbn from "zxcvbn";
const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const snackbarSuccess = ref(false);
const snackbarError = ref(false);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            snackbarSuccess.value = true
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
const passwordStrength = ref(0);
const calculatePasswordStrength = (password) => {
    const result = zxcvbn(password);
    let score = result.score;
    return passwordStrength.value = Math.min(score * 25, 100);
}

watch(() => form.password,
    (newValue) => {
        calculatePasswordStrength(newValue)
        startProgress()
        console.log(passwordStrength.value, )
    })

const progressColor = ref("pink");

const startProgress = () => {
    progressColor.value = 'pink';
    if (passwordStrength.value >= 50) {
        progressColor.value = 'success';
    }
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Actualizar contraseña</h2>

            <p class="mt-1 text-sm text-gray-600">
                Asegurate de tener una contraseña segura.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
<!--                <InputLabel for="current_password" value="Contraseña actual" />-->

<!--                <TextInput-->
<!--                    id="current_password"-->
<!--                    ref="currentPasswordInput"-->
<!--                    v-model="form.current_password"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    autocomplete="current-password"-->
<!--                />-->

<!--                <InputError :message="form.errors.current_password" class="mt-2" />-->
            </div>

            <div>
                <InputLabel for="password" value="Nueva contraseña" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
<!--                <InputError :message="form.errors.password" class="mt-2" />-->
            </div>

            <div class="flex justify-center">
                <v-progress-linear
                    v-model="passwordStrength"
                    :value="passwordStrength"
                    height="25"
                    :color="progressColor"
                >
                    <template v-if="passwordStrength === 0">
                        Fuerza de la contraseña
                    </template>
                    <template v-if="passwordStrength === 25">
                        Fácil
                    </template>
                    <template v-if="passwordStrength === 50">
                        Segura
                    </template>
                    <template v-if="passwordStrength === 75">
                        Muy segura
                    </template>
                    <template v-if="passwordStrength === 100">
                        Indescifrable
                    </template>
                </v-progress-linear>
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar contraseña" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

<!--                <InputError :message="form.errors.password_confirmation" class="mt-2" />-->
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
        <v-snackbar
            v-model="snackbarSuccess"
            vertical
            color="success"
        >
            <div class="text-subtitle-1 pb-2">!Listo¡</div>

            <p>Se actualizado con exito la contraseña</p>

            <template v-slot:actions>
                <v-btn
                    color="indigo"
                    variant="text"
                    @click="snackbarSuccess = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
        <v-snackbar
            v-model="snackbarError"
            vertical
            color="error"
        >
            <div class="text-subtitle-1 pb-2">!Error¡</div>

            <template v-if="$page.props.errors.password">
                Debe ingresar una contraseña valida
            </template>
            <template v-if="$page.props.errors.password_confirmation">
                Las contraseñas no coinciden
            </template>

            <template v-slot:actions>
                <v-btn
                    color="indigo"
                    variant="text"
                    @click="snackbarError = false"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </section>
</template>
