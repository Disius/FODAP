<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted, ref} from "vue";
import CustomSnackBar from "@/Components/CustomSnackBar.vue";

const form = useForm({
    nameInstituto: ""
});
const snackbarDialog = ref(false);
const message = ref("")
const color = ref()
const timeout = ref(0);


const snackEventActivator = () => {
    snackbarDialog.value = true;
    message.value = "Parece que los recursos se han actualizado, por favor recarga la pagina"
    color.value = "warning"
    timeout.value = 5000
};
const snackErrorActivator = () => {
    snackbarDialog.value = true;
    message.value = "No se pudo procesar la solicitud"
    color.value = "error"
    timeout.value = 5000
};
const snackSuccessActivator = () => {
    snackbarDialog.value = true;
    message.value = "Procesado correctamente"
    color.value = "success"
    timeout.value = 5000
};
const props = defineProps({
    instituto: Array,
    modelValue: Boolean
});

const emit = defineEmits([
    'update:modelValue'
]);
const submit = () => {
    if (props.instituto.length === 0){
        return form.post(route('create.instituto'), {
            onSuccess: () => {
                snackSuccessActivator()
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    }else{
        return form.put(route('update.instituto', props.instituto[0].id), {
            onSuccess: () => {
                snackSuccessActivator()
            },
            onError: () => {
                snackErrorActivator()
            }
        })
    }
}

onMounted(() => {
    if (props.instituto.length === 0){
        return form.nameInstituto
    }else{
         form.nameInstituto = props.instituto[0].name
    }
})
</script>

<template>
    <v-dialog width="500" v-model="props.modelValue" >
        <v-card>
            <v-card-title>Establecer nombre del Director(a)</v-card-title>
            <v-card-text>
                    <div class="grid grid-cols-1">
                        <div class="flex justify-center mt-4">
                            <v-text-field v-model="form.nameInstituto">

                            </v-text-field>
                        </div>
                    </div>
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col align="end">
                        <v-btn color="error" @click="emit('update:modelValue', false)">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col align="center">
                        <v-btn @click="submit" color="success">
                            Guardar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <CustomSnackBar :timeout="timeout" :color="color" :message="message" v-model="snackbarDialog" @update:modelValue="snackbarDialog = $event">

    </CustomSnackBar>
</template>

<style scoped>

</style>
