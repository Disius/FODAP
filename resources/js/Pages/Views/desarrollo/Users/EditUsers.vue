<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateProfileInformationFormSelected
    from "@/Pages/Views/desarrollo/forms/UpdateProfileInformationFormSelected.vue";
import UpdatePasswordFormSelected from "@/Pages/Views/desarrollo/forms/UpdatePasswordFormSelected.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const props = defineProps({
    user: Object,
    docente: Array,
    departamento: Array,
    rol: Array,
})
const message = ref("")
const timeout = ref()
const color = ref("")
const snackbar = ref(false)

function suceess(){
    message.value = "Actualizado con exito"
    color.value = "success"
    timeout.value = 2000;
    snackbar.value = true
    setTimeout(() => {
        snackbarSuccess.value = false;
    }, timeout.value);
}
function error_form() {
    message.value = "Error al actualizar este recurso"
    color.value = "error"
    timeout.value = 2000;
    snackbar.value = true
    setTimeout(() => {
        snackbar.value = false;
    }, timeout.value);
}

const submit = (form) => {
        form.patch(route('update.user', props.user.id), {
            onSuccess: () => {
                suceess()
            },
            onError: () => {
                error_form()
            },
        })
}
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <NavLink :href="route('parametros.edit')" as="button">
                <v-btn icon="mdi-arrow-left" color="blue-darken-1">

                </v-btn>
            </NavLink>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-2">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdateProfileInformationFormSelected :rol="props.rol" :departamento="props.departamento" :docente="props.docente" :user="props.user" @form:update-docente="submit">

                </UpdateProfileInformationFormSelected>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-10">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdatePasswordFormSelected :user="props.user"></UpdatePasswordFormSelected>
            </div>
        </div>
        <CustomSnackBar v-model="snackbar" :message="message" :color="color" @update:modelValue="snackbar = $event"></CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
