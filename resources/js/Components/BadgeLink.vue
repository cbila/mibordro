
<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
});
</script>


<template>
    <Link 
        :href="href" 
        class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">

        <slot />

    </Link>

</template>