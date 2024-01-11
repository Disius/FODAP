<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {computed, ref} from "vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object
    },
    docente: {
        type: Array
    },
    departamento: {
        type: Array
    },
    rol: {
        type: Array,
    }
});

const user = usePage().props.auth.user;
const snackbarSuccess = ref(false);
const message = ref("")
const color = ref("")
const timeout = ref(2000);
const form = useForm({
    email: props.user.email,
    docente_id: props.user.docente_id,
    departamento_id: props.user.departamento_id,
    role: props.user.roles[0].id,
});


const emit = defineEmits([
    'form:updateDocente'
])

const submit = () => {
    emit('form:updateDocente', form)
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información del perfil</h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualizar tu correo institucional
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="email" value="Correo Institucional" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    disabled
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="docente" value="Docente o administrativo asociado a este perfil" />

                <v-autocomplete variant="solo" :items="props.docente" item-title="nombre_completo" item-value="id"
                v-model="form.docente_id"
                >

                </v-autocomplete>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="departamento" value="Departamento" />

                <v-select variant="solo" :items="props.departamento" item-title="nameDepartamento" item-value="id"
                v-model="form.departamento_id"
                >

                </v-select>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="rol" value="Rol del usuario" />

                <v-select variant="solo" :items="props.rol" item-title="name" item-value="id"
                v-model="form.role"
                >

                </v-select>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

<!--            <div v-if="mustVerifyEmail && user.email_verified_at === null">-->
<!--                <p class="text-sm mt-2 text-gray-800">-->
<!--                    Tu correo institucional no esta verificado-->
<!--                    <Link-->
<!--                        :href="route('verification.send')"-->
<!--                        method="post"-->
<!--                        as="button"-->
<!--                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
<!--                    >-->
<!--                        Has click para reenviar el correo de confirmación.-->
<!--                    </Link>-->
<!--                </p>-->

<!--                <div-->
<!--                    v-show="status === 'verification-link-sent'"-->
<!--                    class="mt-2 font-medium text-sm text-green-600"-->
<!--                >-->
<!--                    Un nuevo email de verificación fue enviado a tu correo institucional.-->
<!--                </div>-->
<!--            </div>-->

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </section>
    <CustomSnackBar :message="message" :timeout="timeout" :color="color" v-model="snackbarSuccess" @update:modelValue="snackbarSuccess = $event">

    </CustomSnackBar>
</template>
