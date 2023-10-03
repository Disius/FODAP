<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";

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
    (v) => calculatePasswordStrength(v) >= 50 || 'La contraseña debe ser más fuerte',
];

const calculatePasswordStrength = (password) => {
    // Aquí puedes implementar tu lógica para calcular la fortaleza de la contraseña.
    // Puedes utilizar reglas como longitud, caracteres especiales, letras mayúsculas, etc.
    // Calcula un valor entre 0 y 100 y asígnalo a this.passwordStrength.
    // Por ejemplo:
    passwordStrength.value = Math.min(password.length / 8 * 100, 100);
}

watch(() => form.password,
    (newValue) => {
          calculatePasswordStrength(newValue)
          startProgress()
      console.log(passwordStrength.value)
})

const progressColor = ref("pink");

const startProgress = () => {
   progressColor.value = 'pink'; // Reinicia el color a 'primary'
  //this.progress = 0; // Reinicia el progreso a 0
  if (passwordStrength.value >= 50) {
    progressColor.value = 'success';
  }
  // const interval = setInterval(() => {
  //   //this.progress += 10; // Incrementa el progreso en 10 unidades
  //
  //   // Cambia el color cuando llega al 50% de progreso
  //   if (passwordStrength.value >= 50) {
  //     progressColor.value = 'success';
  //   }
  //
  //   // Finaliza el progreso al llegar al 100%
  //   if (passwordStrength.value  === 100) {
  //     clearInterval(interval);
  //   }
  // }, 100);
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

                    height="10"
                    :color="progressColor"
                ></v-progress-linear>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar contraseña" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

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
