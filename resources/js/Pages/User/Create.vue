<script setup>
import InputError from "@/Components/InputError.vue";
// import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextArea from "@/Components/TextArea.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    companies: Object,
    sgks: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    roles: "",
    company: "",
    identity: "",
    sgk: "",
    recruitment_date: "",
    gsm: "",
    iban: "",
    position: "",
    holidays: "",
    info: "",
});

const create = () => {
    form.post(route("users.store"), {
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
        form.roles = props.user?.roles.map((role) => ({
                name: role.name,
                id: role.id,
            })); 
        form.company = props.user?.company.id;
        form.sgk = props.user?.sgk.id;
        form.errors = {};
    }
});

const roles = props.roles?.map((role) => ({
    name: role.name,
    id: role.id,
}));

const companies = props.companies?.map((company) => ({
    name: company.name,
    id: company.id,
}));

const sgks = props.sgks?.map((sgk) => ({
    name: sgk.name,
    id: sgk.id, 
}));
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">
            <form class="p-6" @submit.prevent="create">
                <h2
                    class="text-lg font-medium text-slate-900 dark:text-slate-100"
                >
                    {{ props.title }} {{ lang().label.add }} 
                </h2>

                <div class="grid grid-cols-1 grid md:grid-cols-2 w-full">
                    <div class="col-span-1 m-4 md:m-6">
                        <div class="mt-2">
                            <Select
                                id="company"
                                class="mt-1 block w-full"
                                v-model="form.company"
                                :options="companies"
                                optionLabel="name"
                                placeholder="Firma"
                                required
                            >
                            </Select>
                            <InputError class="mt-2" :message="form.errors.company" />
                        </div>
                        <div class="mt-2">
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                :placeholder="lang().placeholder.name"
                                :error="form.errors.name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-2">
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                :placeholder="lang().placeholder.email"
                                :error="form.errors.email"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-2">
                            <InputMask id="identity" v-model="form.identity" mask="99999999999" placeholder="TC Kimlik No" fluid />

                            <InputError class="mt-2" :message="form.errors.identity" />
                        </div>
                        
                        <div class="mt-2">
                            <InputMask id="gsm" v-model="form.gsm" mask="(999) 999-9999" :placeholder="lang().placeholder.gsm" fluid />
                            <InputError
                                class="mt-2"
                                :message="form.errors.gsm"
                            />
                        </div>

                        <div class="mt-2">
                            <TextArea
                                id="info"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.info"
                                required
                                :placeholder="lang().placeholder.info"
                                :error="form.errors.info"
                            />
                            <InputError class="mt-2" :message="form.errors.info" />
                        </div>
                    
                    </div>
                    <div class="col-span-1 m-4 md:m-6">
                        <div class="mt-2">
                            <MultiSelect
                                id="roles"
                                class="mt-1 block w-full"
                                v-model="form.roles"
                                :options="roles"
                                optionLabel="name"
                                placeholder="Rol" 
                                display="chip" 
                                required
                            >
                            </MultiSelect>
                            <InputError class="mt-2" :message="form.errors.roles" />
                        </div>

                        <div class="mt-2">
                            <Select
                                id="sgk"
                                class="mt-1 block w-full"
                                v-model="form.sgk"
                                :options="sgks"
                                optionLabel="name"
                                placeholder="SGK Müdürlüğü"
                                required
                            >
                            </Select>
                            <InputError class="mt-2" :message="form.errors.sgk" />
                        </div>
                        <div class="mt-2">
                            
                            <TextInput
                                id="recruitment_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.recruitment_date"
                                :placeholder="lang().placeholder.recruitment_date"
                                :error="form.errors.recruitment_date"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.recruitment_date"
                            />
                        </div>

                        <div class="mt-2">
                            <InputMask id="iban" v-model="form.iban" mask="99 9999 9999 9999 9999 9999 99" placeholder="IBAN" fluid />
                            <InputError
                                class="mt-2"
                                :message="form.errors.iban"
                            />
                        </div>
                        
                        <div class="mt-2">
                            <!-- <InputLabel for="holidays" :value="lang().label.holidays" /> -->
                            <TextInput
                                id="holidays"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.holidays"
                                required
                                :placeholder="lang().placeholder.holidays"
                                :error="form.errors.holidays"
                            />
                            <InputError class="mt-2" :message="form.errors.holidays" />
                        </div>
                        
                        <div class="mt-2">
                            <!-- <InputLabel
                                for="position"
                                :value="lang().label.position"
                            /> -->
                            <TextInput
                                id="position"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.position"
                                :placeholder="
                                    lang().placeholder.position
                                "
                                :error="form.errors.position"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.position"
                            />
                        </div>


                    </div>
                </div>
                <div class="flex justify-end">
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                    >
                        {{ lang().button.close }}
                    </SecondaryButton>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="create"
                    >
                        {{
                            form.processing
                                ? lang().button.add + "..."
                                : lang().button.add
                        }}
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
