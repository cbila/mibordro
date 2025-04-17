<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage} from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ForceDelete from "@/Pages/Activities/ForceDelete.vue";
import { reactive, watch } from "vue";
import Pagination from "@/Components/Pagination.vue";
import SelectInput from "@/Components/SelectInput.vue"; 
import pkg from "lodash";   
import { router } from "@inertiajs/vue3";
// import Dropdown from 'primevue/dropdown';

import {
    XMarkIcon
} from "@heroicons/vue/24/solid";
import DangerButton from "@/Components/DangerButton.vue";

const { _, debounce, pickBy } = pkg;


const props = defineProps({
    title: String,
    filters: Object,
    perPage: Number,
    activities: Object,
    events: Array,
    causers: Array,
    count: Number,
    breadcrumbs: Object,
});

const data = reactive({
    params: {
        search: props.filters.search,
        page: props.filters.page,
        perPage: props.perPage,
        selectedCauser: props.selectedCauser,
        selectedEvent: props.selectedEvent,
    },
    forceDeleteOpen: false,
    activity: null,

    // deleteBulkOpen: false,
    dataSet: usePage().props.app.perpage,
});

watch(
    () => _.cloneDeep(data.params),
    debounce(() => {
        let params = pickBy(data.params);
        router.get(route("activities.index"), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);

// const values = reactive (getDropdownValues(keyword) {
//     console.log(keyword);
// });

</script>

<template>
<Head title="Kayıtlar" />

<AuthenticatedLayout>
    <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
    <Select id="causer" name="causer" filter showClear v-model="data.params.selectedCauser" :options="causers" optionLabel="name" placeholder="Sebep" class="w-1/4 md:w-14rem" />
    <Select id="event" name="event" filter showClear v-model="data.params.selectedEvent" :options="events"  placeholder="Olay" class="w-1/4 ml-4 md:w-14rem " />
    <div class="space-y-4">
        <ForceDelete :show="data.forceDeleteOpen" @close="data.forceDeleteOpen = false" :activity="data.activity" :title="props.title" />
            
            <div class="relative bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="flex justify-between p-2 items-center">
                <div class="flex space-x-2 items-center">
                    <SelectInput v-model="data.params.perPage" :dataSet="data.dataSet" /> 
                    <div class="text-sm text-gray-500">/ {{ count }}</div>
                    <div class="font-medium text-gray-500"></div>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-table">
                <table class="min-w-full">
                    <thead class="uppercase text-sm border-t border-slate-200">
                        <tr class="text-left">
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.causer_id }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.causer_type }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.event }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.subject_id }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.subject_type }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.description }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.created_at }}
                            </th>
                            <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ lang().log.properties }}
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="activities.data.length" >
                        <tr v-for="activity in activities.data" :key="activity.id" class="text-sm">
                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                <!-- <DangerButton v-show="can(['delete-user'])" type="button" @click="
                                    (data.forceDeleteOpen = true),
                                    (data.activity = activity)"
                                    v-tooltip="lang().tooltip.delete">
                                    <XMarkIcon class="w-4 h-4" />
                                </DangerButton> -->
                                {{ activity.id }}
                            </td>
                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                <a v-if="activity.causer_id" class="text-blue-800" target="_blank" :href="route('users.show', [activity.causer_id])">{{ activity.causer_id }}</a>
                            </td>
                            
                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.causer_type }}
                            </td>

                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.event }}
                            </td>

                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.subject_id }}
                            </td>
                            
                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.subject_type }}
                            </td>
                            
                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.description }}
                            </td>

                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.created_at }}
                            </td>

                            <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                                {{ activity?.properties }}
                            </td>
                        </tr>
                    </tbody>
                    <tr v-else >
                        <td class="whitespace-nowrap text-gray-400 px-2 sm:py-3 text-left border-b border-gray-200">
                            Herhangi bir kayıt bulunamadı.
                        </td>
                    </tr>
                </table>
            </div>
            <div class="flex justify-between items-center p-2 border-t border-slate-200">
                <pagination class="mt-6" :links="activities.links" />
            </div>
        </div>
    </div>
</AuthenticatedLayout>

</template>