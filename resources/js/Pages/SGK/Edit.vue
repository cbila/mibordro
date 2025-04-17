<script setup>
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { useForm } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    sgk: Object
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    address: "",
    city: "",
});

const update = () => {
    form.put(route('sgk.update', props.sgk?.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close");
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
};

watchEffect(() => {
    if (props.show) {
        form.name = props.sgk?.name ? props.sgk?.name : '';
        form.address = props.sgk?.address ? props.sgk?.address : ';';
        form.city = props.sgk?.city ? props.sgk?.city : '';
        form.errors = {};
    }
});


</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">
            <form class="p-6" @submit.prevent="update">
                <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                    {{ lang().label.edit }} {{ props.title }}
                </h2>

                <div class="grid grid-cols-1 w-full my-4">

                    <div class="mt-2">
                        <InputLabel for="name" :value="lang().label.name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                            :placeholder="lang().placeholder.name" :error="form.errors.name" requcired />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-2">
                        <InputLabel for="address" :value="lang().label.address" />
                        <TextArea id="address" type="textarea" class="mt-1 block w-full" v-model="form.address"
                            :placeholder="lang().placeholder.address" :error="form.errors.address" required />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="mt-2">
                        <InputLabel for="city" :value="lang().label.city" />
                        <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city"
                            :placeholder="lang().placeholder.city" :error="form.errors.city" required />
                        <InputError class="mt-2" :message="form.errors.city" />
                    </div>

                </div>

                <div class="flex justify-end">
                    <SecondaryButton :disabled="form.processing" @click="emit('close')">
                        {{ lang().button.close }}
                    </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="update">
                        {{
                            form.processing
                            ? lang().button.save + "..."
                            : lang().button.save
                        }}
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
