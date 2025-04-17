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
    class="inline-flex w-auto cursor-pointer select-none appearance-none items-center justify-center space-x-1 rounded border border-gray-200 bg-yellow-500 px-3 py-2 text-sm font-medium text-white transition hover:border-yellow-200 hover:bg-yellow-400 active:bg-yellow-500 focus:yellow-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">

    <slot />
    </button>
</template>
