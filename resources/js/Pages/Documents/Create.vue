<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from '@inertiajs/vue3';
import Modal from "@/Components/Modal.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { ref } from 'vue';
import { now } from "lodash";


let props = defineProps({
    show: Boolean,
    title: String,
    user: Object,
    categories: Object,
    date: Number
});


const emit = defineEmits(["close"]);


const form = useForm({
    category: '',
    alias: '',
    file: null,
    description: '',
    date: props.date
})

const create = () => {
    form.post(route('documents.store', props.user.id), {
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

let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();
let prevMonth = (month === 0) ? 11 : month -1;
let prevYear = (prevMonth === 11) ? year - 1 : year;
let nextMonth = (month === 11) ? 0 : month + 1;
let nextYear = (nextMonth === 0) ? year + 1 : year;

const date = ref();
const minDate = ref(new Date());
const maxDate = ref(new Date());

minDate.value.setMonth(prevMonth);
minDate.value.setFullYear(prevYear);
maxDate.value.setMonth(nextMonth);
maxDate.value.setFullYear(nextYear);

</script>


<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">

        <form class="p-6" @submit.prevent="submit">
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                {{ lang().label.add }}
            </h2>


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
                    <span class="text-gray-400 text-sm">pdf, doc, docx, xls, xlsx, ppt, pptx, jpg, jpeg, png max: 50 MB</span> 
                    <InputError class="mt-2" :message="form.errors.alias" />
                </div>

                <div class="mt-2">
                    <InputLabel for="date" :value="lang().label.month" />
                    <DatePicker v-model="form.date" view="date" dateFormat="yy/mm" :manualInput="false" showIcon fluid  />
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

                <div class="my-4">
                    <input type="file" @input="form.file = $event.target.files[0]" />
                </div>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                

                <div v-if="form.errors.file" class="text-red-600 p-2 rounded my-2">{{ form.errors.file }}</div>
                

                <div class="flex justify-end">
                    <!-- <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                    >
                        {{ lang().button.close }}
                    </SecondaryButton> -->
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.progress }"
                        :disabled="form.progress"
                        @click="create"
                    >
                        {{
                            form.progress
                                ? lang().button.add + "..."
                                : lang().button.add
                        }}
                    </PrimaryButton>
                </div>
                
            </div>
        </form>

        </Modal>
    </section>
</template>