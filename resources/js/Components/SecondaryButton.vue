<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
            class="inline-flex w-auto cursor-pointer select-none 
            appearance-none items-center justify-center space-x-1
             rounded border border-gray-200 bg-gray-700 px-3 py-2 
             text-sm font-medium text-white transition hover:border-gray-300 
             hover:bg-gray-600 active:bg-gray-700 focus:gray-gray-300 
             focus:outline-none focus:ring-2 focus:ring-gray-300">


        <slot />
    </button>
</template>
