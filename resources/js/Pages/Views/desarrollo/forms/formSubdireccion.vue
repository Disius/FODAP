<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted, ref} from "vue";

const form = useForm({
    name: ""
});
const snackSuccess = ref(false);
const snackError = ref(false);
const props = defineProps({
    sub: Array
})
const submit = () => {
    if (props.sub.length === 0){
        return form.post(route('create.sub'), {
            onSuccess: () => {
                snackSuccess.value = true
            },
            onError: () => {
                snackError.value = true
            }
        })
    }else{
        return form.put(route('update.sub', props.sub[0].id), {
            onSuccess: () => {
                snackSuccess.value = true
            },
            onError: () => {
                snackError.value = true
            }
        })
    }
}

onMounted(() => {
    if (props.sub.length === 0){
        return form.name
    }else{
         form.name = props.sub[0].name
    }
})
</script>

<template>
    <form @submit.prevent="submit">
        <div class="flex justify-start">
            <input-label for="name" value="Nombre del subdirector(a): "></input-label>
        </div>
        <div class="grid grid-cols-2">
            <div class="flex justify-center mt-4">
                <v-text-field v-model="form.name">

                </v-text-field>
            </div>
            <div class="flex justify-start mt-6 ml-6">
                <v-btn @click="submit">
                    Guardar
                </v-btn>
            </div>
        </div>
    </form>
    <v-snackbar
        v-model="snackSuccess"
        vertical
        color="success"
    >
        <div class="text-subtitle-1 pb-2"></div>

        <p>Se actualizo con exito</p>

        <template v-slot:actions>
            <v-btn
                variant="text"
                @click="snackSuccess = false"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
    <v-snackbar
        v-model="snackError"
        vertical
        color="error"
    >
        <div class="text-subtitle-1 pb-2"></div>

        <p>Error al actualizar</p>

        <template v-slot:actions>
            <v-btn
                variant="text"
                @click="snackError = false"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
</template>

<style scoped>

</style>
