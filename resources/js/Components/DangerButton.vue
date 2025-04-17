<template>
    <button
    class="inline-flex w-auto cursor-pointer select-none appearance-none items-center justify-center space-x-1 rounded border border-gray-200 bg-red-700 px-3 py-2 text-sm font-medium text-white transition hover:border-red-300 hover:bg-red-600 active:bg-red-700 focus:red-gray-300 focus:outline-none focus:ring-2 focus:ring-red-300">

        <!-- class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
    > -->
        <slot />
    </button>
</template>
