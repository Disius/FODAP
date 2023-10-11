<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const props = defineProps({
    user: Object
});
const confirmingUserDeletion = ref(false);
const EmailInput = ref(null);

const form = useForm({
    id: props.user.id,
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => EmailInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('destroy.users'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => "No se logro eliminar al usuario",
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};

</script>

<template>
    <section class="space-y-6">
        <DangerButton @click="confirmUserDeletion">
            <v-icon>
                mdi-delete-forever
            </v-icon>
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Esta seguro que desea borrar la cuenta?
                </h2>

                <div class="mt-6">
                    <InputLabel for="email" value="Correo Institucional" class="sr-only" />

                    <TextInput
                        id="email"
                        ref="EmailInput"
                        v-model="props.user.email"
                        class="mt-1 block w-3/4"
                        placeholder="Correo Institucional"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.id" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Borrar Cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
