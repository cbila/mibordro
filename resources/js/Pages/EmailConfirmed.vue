<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    auth: Object
});

</script>

<template>

    <Head :title="title" />

    <AuthenticatedLayout>

    
        <div class="flex items-center justify-center mt-12 font-bold text-green-600">
            E-postanız doğrulanmıştır. Teşekkür ederiz.
        </div>
        
        <div class="flex items-center justify-center mt-12 font-bold text-green-600">
            <Link :href="route('user.show', auth.user.id)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Profilime Git
            </Link>
        </div>
	

    </AuthenticatedLayout>


</template>