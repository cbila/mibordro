<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useFormatDate } from '@/composables/useFormatDate';
import Pagination from '@/Components/Pagination.vue'


const props = defineProps({
    user: Object,
    documents: Object,
});

let { formatDate } = useFormatDate();

</script>

<template>
    <Head title="Bordro" />

    <ProfileLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $page.props.auth.user.name }}></h2>
        </template>


        <div class="bg-white mt-2 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Bordro
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tarih
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Açıklama
                        </th>

                    </tr>
                </thead>


                <tbody>
                    <tr v-for="document in documents.data" :key="document.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ document.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ formatDate(document.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ document.description}}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a class="px-6 py-6 focus:text-indigo-500" :href="`/documents/${user.id}/${document.id}`">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </td>
                        <!-- <td>
                            <div v-if="can('delete-document')" class="sm:rounded-lg">
                                <DeleteDocumentForm :doc_id="document.id" />
                            </div>
                        </td> -->
                    </tr>

                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="$page.props.documents.links" />
    </ProfileLayout>
</template>



