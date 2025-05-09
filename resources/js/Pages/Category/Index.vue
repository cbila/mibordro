<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AddButton from "@/Components/AddButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";

import DangerButton from "@/Components/DangerButton.vue";
import InfoButton from "@/Components/InfoButton.vue";
import {
    ArrowLeftIcon,
    PencilIcon,
    TrashIcon,
    XMarkIcon
} from "@heroicons/vue/24/solid";

import { reactive, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

import Create from "@/Pages/Category/Create.vue";
import Edit from "@/Pages/Category/Edit.vue";
import Delete from "@/Pages/Category/Delete.vue";
import ForceDelete from "@/Pages/Category/ForceDelete.vue";
import Pagination from '@/Components/Pagination.vue'
import pkg from "lodash";
import { router } from "@inertiajs/vue3";

const { _, debounce, pickBy } = pkg;


const props = defineProps({
    title: String,
    filters: Object,
    categories: Object,
    breadcrumbs: Object,
    perPage: Number,

});

const form = useForm({
    name: '',
})

const restore = (category) =>{
    router.patch(route('category.restore', category));
}


const data = reactive({
    params: {
        perPage: props.perPage,
        page: props.page,
        trashed: props.filters.trashed
    },
    category: null,
    createOpen: false,
    editOpen: false,
    deleteOpen: false,
    forceDeleteOpen: false,
    dataSet: usePage().props.app.perpage,
});

watch(
    () => _.cloneDeep(data.params),
    debounce(() => {
        let params = pickBy(data.params);
        router.get(route("category.index"), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);
</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />

        <div class="flex justify-end mb-4 text-right">
            <AddButton v-show="can(['create-document'])" class="rounded-none" @click="data.createOpen = true"></AddButton>
            <Create :show="data.createOpen" @close="data.createOpen = false" :title="props.title" />
            <Edit :show="data.editOpen" @close="data.editOpen = false" :title="props.title" :category="data.category"/>
            <Delete :show="data.deleteOpen" @close="data.deleteOpen = false" :category="data.category"/>
            <ForceDelete :show="data.forceDeleteOpen" @close="data.forceDeleteOpen = false" :category="data.category" :title="props.title" />
        </div>

        <div class="space-y-4">
            <div class="relative bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="flex justify-between p-2 items-end">
                    <div class="flex space-x-2 items-center">
                        <SelectInput v-model="data.params.perPage" :dataSet="data.dataSet" />
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input id="trashed" type="checkbox" value="" class="sr-only peer" v-model="data.params.trashed">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </span>
                        </label>
                    </div>
                </div>

                <div class="overflow-x-auto scrollbar-table">
                    <table class="min-w-full">
                        <thead class="uppercase text-sm border-t border-slate-200 dark:border-slate-700">
                            <tr class="dark:bg-slate-900/50 text-left">
                                <th
                                    class="px-2 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th class="px-2 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    v-on:click="order('name')">
                                    <div class="flex justify-between items-center">
                                        <span>{{ lang().label.name }}</span>
                                        <!-- <ChevronUpDownIcon class="w-4 h-4" /> -->
                                    </div>
                                </th>   
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white text-sm text-gray-700">
                            <tr v-for="(category, index) in categories.data" :key="category.id">
                                <td class="whitespace-nowrap text-gray-400 py-4 px-2 sm:py-3 text-center border-b border-gray-200">
                                    {{ ++index }}
                                </td>
                                <td class="whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex text-left">
                                        <div class="ml-4">
                                            <Link href="#"
                                                class="text-sm leading-5 font-medium text-gray-900">
                                            {{ category.name }}
                                            </Link>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap sm:py-3 border-b border-gray-200">
                                    <div v-show="! data.params.trashed" class="flex justify-center items-center">
                                        <InfoButton v-show="can(['update-document'])" type="button" @click="
                                            (data.editOpen = true),
                                            (data.category = category)"
                                            v-tooltip="lang().tooltip.edit">
                                            <PencilIcon class="w-4 h-4" />
                                        </InfoButton>

                                        <DangerButton v-show="can(['delete-document'])" type="button" @click="
                                            (data.deleteOpen = true),
                                            (data.category = category)" 
                                            v-tooltip="lang().tooltip.delete">
                                            <TrashIcon class="w-4 h-4" />
                                        </DangerButton>
                                    </div>

                                    <div v-show="data.params.trashed" class="rounded-md overflow-hidden">
                                        <SecondaryButton v-show="can(['delete-document'])" type="button" @click="
                                            restore (category)" 
                                            v-tooltip="lang().tooltip.restore">
                                            <ArrowLeftIcon class="w-4 h-4" />
                                        </SecondaryButton>
                                        <DangerButton v-show="can(['delete-document'])" type="button" @click="
                                            (data.forceDeleteOpen = true),
                                            (data.category = category)"
                                            v-tooltip="lang().tooltip.delete">
                                            <XMarkIcon class="w-4 h-4" />
                                        </DangerButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center p-2 border-t border-slate-200 dark:border-slate-700">
                    <pagination class="mt-6" :links="props.categories.links" :filters="data.params" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



