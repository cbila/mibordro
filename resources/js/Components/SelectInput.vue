<script setup>
import { ref } from "vue";

defineProps(["modelValue", "dataSet"]);

defineEmits(["update:modelValue"]);

const input = ref(null);
</script>

<template>
    <select
        class="border-slate-300 focus:border-primary  focus:ring-primary rounded-md shadow-sm placeholder:text-slate-400"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <option :key=0 :value="null">Lütfen Seçiniz</option>
        <option
            v-for="(data, index) in dataSet"
            :key="index"
            :value="data.value"
        >
            {{ data.label }}
        </option>
    </select>
</template>
