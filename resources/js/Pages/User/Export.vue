<script setup>
import Modal from "@/Components/Modal.vue";
import { reactive} from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    selectedId: Array

});

const data = reactive({
    selectedWriter: 'xlsx',
    writers: [  
        {'key': 'xlsx', 'name': 'xlsx'},
        {'key': 'xls', 'name': 'xls'},
        {'key': 'ods', 'name': 'ods'},
        {'key': 'csv', 'name': 'csv'},
        {'key': 'html', 'name': 'html'},
        {'key': 'mpdf', 'name': 'pdf'},
        ]

});

const emit = defineEmits(["close"]);



</script>

<template>
    <section class="space-y-6" >
        <Modal :show="props.show" @close="emit('close')">
            <div class="p-6" @submit.prevent="update">
                <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                    Dışa Aktar 
                </h2>
                <div class="flex justify-between m-6">
                    <div v-for="writer in data.writers" :key="writer.key">
                        <RadioButton v-model="data.selectedWriter" :inputId="writer.key" name="dynamic" :value="writer.name" />
                        <label :for="writer.key" class="ml-2">{{ writer.name }}</label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <Button
                        severity="secondary" 
                        @click="emit('close')"
                    >
                        {{ lang().button.close }}
                    </Button>
                    <Button as="a" @click="emit('close')" label="Aktar" :href="route('user.export', {'selectedId': props.selectedId, 'selectedWriter': data.selectedWriter})"  
                    target="_blank" rel="noopener" class="ml-3"/>
                </div>

            </div>
        </Modal>
    </section>
</template>
