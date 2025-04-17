<script setup>
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
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
    document: Object,
    categories: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    alias: "",
    category: "",
    date: "",
    description: "",
});

const update = () => {
    form.patch(route('documents.update', props.document.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close");
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
};

const categories = props.categories?.map((category) => ({
    label: category.name,
    value: category.id,
}));

watchEffect(() => {
    if (props.show) {
        form.alias = props.document?.alias;
        form.category = props.document?.category_id;
        form.date = props.document.date;
        form.description = props.document?.description;
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
                    <div class="grid grid-cols-1 w-full my-4">
                <div class="mt-2">
                    <InputLabel for="category" :value="lang().label.category" />
                    <SelectInput
                        id="category"
                        class="mt-1 block w-full"
                        v-model="form.category"
                        :dataSet="categories"
                        required
                    >
                    </SelectInput>
                    <InputError class="mt-2" :message="form.errors.category" />
                </div>

                <div class="mt-2">
                    <InputLabel for="alias" :value="lang().label.alias" />
                    <TextInput
                        id="alias"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.alias"
                        required
                        :placeholder="lang().placeholder.alias"
                        :error="form.errors.alias"
                    />
                    <span class="text-gray-400 text-sm">Yalnızca pdf, max: 500 MB</span> 
                    <InputError class="mt-2" :message="form.errors.alias" />
                </div>

                <div class="mt-2">
                    <InputLabel for="date" :value="lang().label.month" />
                    <DatePicker v-model="form.date" view="date" dateFormat="dd.mm.yy" :manualInput="false" showIcon fluid  />
                    <InputError class="mt-2" :message="form.errors.date" />
                
                </div>
                
                <div class="mt-2">
                    <InputLabel for="description" :value="lang().label.description" />
                    <TextInput
                        id="description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        :placeholder="lang().placeholder.description"
                        :error="form.errors.description"
                    />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
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
