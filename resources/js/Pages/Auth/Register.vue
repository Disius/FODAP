<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import zxcvbn from 'zxcvbn';


const props = defineProps({
    role: {type: String},
    departamento: {type: Array}
});
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    departamento_ads: null,
    role: Number(props.role),
});
const passwordMatch = [
  (v) => {
    if (form.password === form.password_confirmation) return true;

    return 'La contraseña no coincide.';
  },
]
// function checkPasswords() {
//     passwordMatch.value = form.password === form.password_confirmation;
// }
const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const email_rules = [
    v => {
        return /^[A-Za-z0-9._%+-]+@(tuxtla\.tecnm\.mx|tecnm\.mx)$/.test(v) || "Su email debe ser exclusivamente institucional"
    }
];

const passwordStrength = ref(0);

const passwordRules = [
    (v) => !!v || 'La contraseña es requerida',
    (v) =>  v && v.length >= 8 || 'La contraseña debe tener al menos 8 caracteres',
    (v) => {
        if (calculatePasswordStrength(v) >= 25) return true

        return 'La contraseña debe ser más fuerte'
    },
    // (v) => calculatePasswordStrength(v) >= 1 || 'La contraseña es fácil',
    // (v) => calculatePasswordStrength(v) >= 2 || 'La contraseña es algo adivinable',
    // (v) => calculatePasswordStrength(v) >= 3 || 'La contraseña es segura',
    // (v) => calculatePasswordStrength(v) >= 4 || 'La contraseña es muy segura',

];

// const getStrength = () => {
//   const result = zxcvbn(form.password);
//   return result.score;
// }
const calculatePasswordStrength = (password) => {
    const result = zxcvbn(password);
    let score = result.score;
    return passwordStrength.value = Math.min(score * 25, 100);
}

watch(() => form.password,
    (newValue) => {
          calculatePasswordStrength(newValue)
          startProgress()

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
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">

            <div class="mt-4">
                <InputLabel for="email" value="Correo institucional" />

<!--                <TextInput-->
<!--                    id="email"-->
<!--                    type="email"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.email"-->
<!--                    required-->
<!--                    autocomplete="username"-->
<!--                />-->
                <v-text-field
                v-model="form.email"
                :rules="email_rules"
                >

                </v-text-field>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

<!--                <TextInput-->
<!--                    id="password"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.password"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->
                <v-text-field
                    v-model="form.password"
                    type="password"
                    :rules="passwordRules"
                ></v-text-field>
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

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar contraseña" />

                <v-text-field
                v-model="form.password_confirmation"
                :rules="passwordMatch"
                type="password"
                >

                </v-text-field>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
<!--            <p v-if="passwordMatch === true">Las contraseñas coinciden</p>-->
<!--            <p v-else-if="passwordMatch === false">Las contraseñas no coinciden</p>-->
            <div class="mt-4">
                <InputLabel for="departamento_adscrito" value="Departamento adscrito" />

                <v-select :items="props.departamento" item-title="nameDepartamento" item-value="id" v-model="form.departamento_ads"></v-select>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    ¿Ya te encuentras registrado?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
