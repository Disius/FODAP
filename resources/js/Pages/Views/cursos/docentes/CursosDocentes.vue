<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {FODAPStore} from "@/store/server.js";
import NavLink from "@/Components/NavLink.vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";


const store = FODAPStore();

const props = defineProps({
    cursos: Array,
    auth: Object
});

const form = useForm({
    id_docente: props.auth.user.docente_id,
});
const alert = ref(false);
const search = ref("");
const color = ref("")
const message = ref("")
const snackbar = ref(false)
const timeout = ref(0);

const snackEventActivator = () => {
    snackbar.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackErrorActivator = () => {
    snackbar.value = true;
    message.value = "Ops, algo salió mal. Por favor, debe revisar si actualizo sus datos."
    color.value = "error"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};
const snackSuccessActivator = () => {
    snackbar.value = true;
    message.value = "¡Operación completada con éxito!"
    color.value = "success"
    timeout.value = 5000
    setTimeout(() => {
        snackbar.value = false
    }, timeout.value)
};

const submit = (item) => {
    form.post(route('inscripcion.docente', item), {
        onSuccess: () => {
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}
const id_curso = useForm({
    curso: null
})
const desinscribirme = (id, item) => {
    id_curso.curso = item
    id_curso.post(route('mi.desinscrito', id), {
        onSuccess: () => {
            snackSuccessActivator()
        },
        onError: () => {
            snackErrorActivator()
        }
    })
}

onMounted(() => {
    window.Echo.private(`App.Models.User.${props.auth.user.id}`).notification((notification) => {
        switch (notification.type){
            case 'App\\Notifications\\NewDeteccionNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\DeteccionEditadaNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\AceptadoNotification':
                props.auth.usernotifications++
                break;
            case 'App\\Notifications\\ObservacionNotification':
                props.auth.usernotifications++
                break;
        }
    });

    window.Echo.private("cursos-aceptados").listen("CursosAceptados", (event) => {
        snackEventActivator()
    })
});
</script>

<template>
    <Head title="Cursos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-medium text-gray-900">Cursos</h2>
        </template>
        <template v-if="props.cursos.length !== 0">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-virtual-scroll
                        :items="props.cursos"
                        height="300"
                        item-height="50"
                        class="mt-4"

                    >
                        <template v-slot:default="{ item }">
                            <v-list-item>
                                <template v-slot:prepend>
                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">
                                        <template v-if="item.estado === 0">
                                            <v-chip variant="flat" color="warning" prepend-icon="$info">
                                                Curso por realizar
                                            </v-chip>
                                        </template>
                                        <template v-else>
                                            <v-chip variant="flat" color="success" prepend-icon="$info">
                                                En curso
                                            </v-chip>
                                        </template>
                                    </div>
                                </template>

                                <div class="ml-8">
                                    <v-list-item-title class="text-h5">{{ item.nombreCurso }}</v-list-item-title>
                                    <v-list-item-subtitle class="text-h6">
                                        {{item.objetivoEvento}}
                                    </v-list-item-subtitle>
                                    <v-list-item-action class="mt-5">
                                        <div v-if="item.docente_inscrito.some(inscrito => inscrito.id === props.auth.user.docente_id)">
                                            <danger-button @click="desinscribirme(props.auth.user.docente_id, item.id)">Desinscribirme</danger-button>
                                        </div>
                                    </v-list-item-action>
                                </div>
                                <div class="d-flex justify-space-between px-4 pt-4">
                                    <div class="d-flex align-center text-caption text-medium-emphasis me-1">

                                    </div>
                                    <div v-if="item.docente_inscrito.some(inscrito => inscrito.id === props.auth.user.docente_id)">
                                                <v-alert variant="outlined" color="success">
                                                    <strong class=""> Inscrito </strong>
                                                </v-alert>

                                    </div>

                                    <div v-else>
                                        <secondary-button type="submit" @click="submit(item.id)">Inscribirse</secondary-button>
                                    </div>
                                </div>
                            </v-list-item>
                        </template>
                    </v-virtual-scroll>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 mt-7 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-alert
                    border="start"
                    color="info"
                    type="info"
                    title="Cursos"
                    >
                        <strong>Actualmente no hay cursos que visualizar !Pronto deberian ser agregados!</strong>
                    </v-alert>
                </div>
            </div>
        </template>
        <CustomSnackBar v-model="snackbar" :message="message" :color="color" @update:modelValue="snackbar = $event">

        </CustomSnackBar>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
