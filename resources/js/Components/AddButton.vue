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
    class="inline-flex w-auto cursor-pointer select-none appearance-none items-center justify-center space-x-1 rounded border border-gray-200 bg-emerald-700 px-3 py-2 text-sm font-medium text-white transition hover:border-emerald-300 hover:bg-emerald-600 active:bg-emerald-700 focus:emerald-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-300">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    <slot />
    </button>
</template>
