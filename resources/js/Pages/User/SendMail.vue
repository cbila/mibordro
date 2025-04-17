<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    show: Boolean,
    title: String,
    user: Object,
});

const emit = defineEmits(["close"]);

const MailTypes = ( [
    { value: 'reset', label: 'Şifre Sıfırlama Bağlantısı' },   
    { value: 'custom', label: 'Özel e-posta' },   
]);


const form = useForm({
    mailType: '',
    user_id: '',
    subject: '',
    message: ''
});



const submit = () => {
    form.user_id = props.user.id;

    form.post(route("mail.store"), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close");
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
};


</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'lg'">

            <form class="p-6" @submit.prevent="submit">
                <b>Kime: {{ props.user.name }}</b>, {{ props.user.email }}
                <div class="mt-4">
                    <InputLabel for="mailType" :value="lang().label.mailType" />
                    <SelectInput
                        id="mailType"
                        class="mt-1 block w-full"
                        v-model="form.mailType"
                        required
                        :dataSet="MailTypes"
                    >
                    </SelectInput>
                    <InputError class="mt-2" :message="form.errors.mailType" />
                </div>
                
                <div class="mt-2" v-show="form.mailType=='custom'">
                    <InputLabel for="subject" :value="lang().label.subject" />
                    <TextInput
                        id="subject"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.subject"
                        :placeholder="lang().placeholder.subject"
                        :error="form.errors.subject"
                        required
                    >
                    </TextInput>
                    <InputError class="mt-2" :message="form.errors.subject" />
                </div>

                <div class="mt-2" v-show="form.mailType=='custom'">
                    <InputLabel for="message" :value="lang().label.message" />
                    <TextArea
                        id="message"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.message"
                        required
                        :placeholder="lang().placeholder.message"
                        :error="form.errors.message"
                    />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                    >
                        {{ lang().button.close }}
                    </SecondaryButton>
                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="submit"
                    >
                        {{
                            form.processing
                                ? lang().button.send + "..."
                                : lang().button.send
                        }}
                    </DangerButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
