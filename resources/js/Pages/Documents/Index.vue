<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Create from "@/Pages/Documents/Create.vue";
import Edit from "@/Pages/Documents/Edit.vue";
import Delete from "@/Pages/Documents/Delete.vue";
import { reactive, watch } from "vue";
import AddButton from "@/Components/AddButton.vue";
import InfoButton from "@/Components/InfoButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {
    PencilIcon,
    TrashIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/solid";
import { router } from "@inertiajs/vue3";
import { format } from 'date-fns'

import pkg from "lodash";   

const { _, debounce } = pkg;


const props = defineProps({
    selectedYear: Number,
    user: Object,
    title: String,
    breadcrumbs: Object,
    categories: Object,
    years: Array,
    documents: Object,
    category: Number,
});     

const data = reactive({
    params: {
        selectedYear: props.selectedYear,
        category: props.category
    },
    createOpen: false,
});

watch(
    () => _.cloneDeep(data.params),
    debounce(() => {
        // let selectedYear = pickBy(data.params.selectedYear);
        router.get(route("documents.index", props.user.id), data.params,{
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    })
);



// const sizeOf = function (bytes) {
//     if (bytes == 0) { return "0.00 B"; }
//     var e = Math.floor(Math.log(bytes) / Math.log(1024));
//     return (bytes/Math.pow(1024, e)).toFixed(2)+' '+' KMGTP'.charAt(e)+'B';
// }


</script>

<template>
    <Head title="Bordro" />

    <AuthenticatedLayout>
        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        <div class="flex flex-col gap-3 pb-6">
            <div>
                <h3 class="text-xl text-blue-600 relative font-bold leading-6">
                <Link v-if="user" :href="route('users.show', user.id)" >{{ user.name }}</Link>
                </h3>
                <p class="text-sm text-gray-600">{{ user.email }}</p>
            </div>

            <div class="flex justify-between">
                <div>
                    <Select v-model="data.params.selectedYear" :options="years"  />
                </div>
                <div v-show="can(['update-document'])" >
                    <AddButton v-show="can(['create-document'])" class="rounded-none" @click="data.createOpen = true"></AddButton>
                </div>
            </div>

            <div class="card">
                <Tabs value="0" scrollable>
                    <TabList>
                        <Tab v-for="category in categories" 
                            @click="data.params.category = category.id" 
                            :key="category.id" :value="category.name"> 
                            {{category.name}} ({{ category.documents_count }})
                        </Tab>
                    </TabList>
                </Tabs>
            </div>

            <div v-show="can(['update-document'])">
                <Create
                    :show="data.createOpen"
                    @close="data.createOpen = false"
                    :title="props.title"
                    :user="user"
                    :categories="categories"
                    />
            
                <Edit :show="data.editOpen" @close="data.editOpen = false" :title="props.title" :document="data.document" :categories="categories"/>
                <Delete :show="data.deleteOpen" @close="data.deleteOpen = false" :document="data.document"/>
            <!-- <ForceDelete :show="data.forceDeleteOpen" @close="data.forceDeleteOpen = false" :company="data.company" :title="props.title" /> -->
            </div>

            <div class="relative bg-white shadow sm:rounded-lg">
                <div class="overflow-x-auto scrollbar-table">
                    <table class="min-w-full">
                        <thead class="uppercase text-sm border-t border-slate-200">
                            <tr class="text-left">
                                <!-- <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    #
                                </th> -->
                                <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider"
                                    v-on:click="order('name')">
                                    <span>{{ lang().label.alias }}</span>
                                </th>
                                <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    <span>{{ lang().label.download }}</span>
                                </th>
                                <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    <span>Tarih</span>
                                </th>
                                <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    <span>{{ lang().label.description }}</span>
                                </th>
                                <!-- <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    <span>{{ lang().label.size }}</span>
                                </th> -->

                                <th class="px-4 py-2 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500  tracking-wider">
                                    <div class="flex justify-between items-center"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="documents.data.length" >
                            <tr v-for="document in documents.data" :key="document.id" class="text-gray-600">
                                <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200">
                                    <a :href="route('documents.view', [user.id, document.id])" target="_blank"
                                        class=" flex leading-5 font-medium text-blue-600 hover:text-blue-900">
                                        <img v-if="document.extension==='pdf'" src="/img/pdf.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='jpg'" src="/img/jpg.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='doc'" src="/img/doc.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='docx'" src="/img/docx.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='xls'" src="/img/xls.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='xlsx'" src="/img/xls.svg" width="24px" height="32px" class="mr-2"/>
                                        <img v-if="document.extension==='zip'" src="/img/zip.svg" width="24px" height="32px" class="mr-2"/>
                                        {{ document?.alias }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 ">
                                    <a :href="route('documents.download', [user.id, document.id])"
                                        class="leading-5 font-medium text-blue-500">
                                    <ArrowDownTrayIcon class="w-8 h-8 hover:text-blue-900" />
                                    </a>
                                </td>
                                <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200">
                                    <!-- {{ document.date }} -->
                                    <span v-if="document.category_id === 1">{{ format(document.date, 'MM-yyyy','Europe/Istanbul') }}</span>
                                    <span v-else>{{ format(document.date, 'dd-MM-yyyy','Europe/Istanbul') }}</span>
                                </td>
                                <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200">
                                    {{ document?.description }}
                                </td>

                                <!-- <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 text-right">
                                    {{ sizeOf(document.size)}}
                                </td> -->

                                <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex justify-center items-center">
                                        <InfoButton v-show="can(['update-document'])" type="button" @click="
                                            (data.editOpen = true),
                                            (data.document = document)"
                                            v-tooltip="lang().tooltip.edit">
                                            <PencilIcon class="w-4 h-4" />
                                        </InfoButton>
                                        <DangerButton v-show="can(['delete-document'])" type="button" @click="
                                            (data.deleteOpen = true),
                                            (data.document = document)"
                                            v-tooltip="lang().tooltip.delete">
                                            <TrashIcon class="w-4 h-4" />
                                        </DangerButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                            <tr v-else>
                                <td class="whitespace-nowrap text-gray-600 py-2 px-4 sm:py-3 text-center border-b border-gray-200">
                                    Herhangi bir kayıt bulunamadı.
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
            
            <pagination class="mt-6" :links="props.documents.links" />
        </div>
            <Link v-if="user" :href="route('users.show', user.id)" class="inline-flex w-auto cursor-pointer select-none appearance-none items-center justify-center space-x-1 rounded border border-gray-200 bg-blue-700 px-3 py-2 text-sm font-medium text-white transition hover:border-blue-300 hover:bg-blue-600 active:bg-blue-700 focus:blue-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd" />
                </svg>
            </Link>
        
    </AuthenticatedLayout>
</template>



