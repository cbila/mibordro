<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TextInput from "@/Components/TextInput.vue";
import AddButton from "@/Components/AddButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import MailButton from "@/Components/MailButton.vue";
import InfoButton from "@/Components/InfoButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { reactive, watch, watchEffect } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import pkg from "lodash";   
import { router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {
    ChevronUpDownIcon,
    PencilIcon,
    ArrowUpIcon,
    TrashIcon,
    ArrowLeftIcon,
    XMarkIcon,
    EnvelopeIcon,
} from "@heroicons/vue/24/solid";
import Create from "@/Pages/User/Create.vue";
import SendMail from "@/Pages/User/SendMail.vue";
import Edit from "@/Pages/User/Edit.vue";
import Delete from "@/Pages/User/Delete.vue";
import ForceDelete from "@/Pages/User/ForceDelete.vue";
import Upload from "@/Pages/Documents/Create.vue";
import Export from "@/Pages/User/Export.vue";


const { _, debounce, pickBy } = pkg;

const props = defineProps({
    auth: Object,
    title: String,
    filters: Object,
    perPage: Number,
    users: Object,
    roles: Object,  
    companies: Object,
    categories: Object,
    sgks: Object,
    breadcrumbs: Object,
    count: Number,
});

const data = reactive({
    params: {
        search: props.filters.search,
        field: props.filters.field,
        order: props.filters.order,
        page: props.filters.page,
        trashed: props.filters.trashed,
        perPage: props.perPage,
        company: props.filters.company
    },
    selectedId: [],
    multipleSelect: false,
    allSelected: false,
    createOpen: false,
    editOpen: false,
    deleteOpen: false,
    forceDeleteOpen: false,
    deleteBulkOpen: false,
    sendMailOpen: false,
    uploadOpen: false,
    createExport: false,
    user: null,
    dataSet: usePage().props.app.perpage,
});

const order = (field) => {
    data.params.field = field;
    data.params.order = data.params.order === "asc" ? "desc" : "asc";
};


const restore = (user) =>{
    router.patch(route('users.restore', user));
}


watch(
    () => _.cloneDeep(data.params),
    debounce(() => {
        let params = pickBy(data.params);
        router.get(route("users.index"), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);

const selectAll = (event) => {
    
    data.selectedId = [];

    if (event.target.checked === true) {
        props.users?.data.forEach((user) => {
            data.selectedId.push(user.id);
        });
    }
};

watchEffect(() => {
    data.allSelected = data.selectedId.length === props.users.data.length;
});


const pluck = property => element => element[property]


</script>


<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        <div class="flex justify-between mb-6">
            <div class="flex">
                <TextInput
                    v-model="data.params.search"
                    type="text"
                    class="block w-3/6 md:w-2/6 lg:w-4/6 rounded-lg"
                    :placeholder="lang().placeholder.search"
                />
                <Select v-model="data.params.company" 
                        v-if="can(['view-company'])"
                        :options="props.companies" 
                        optionLabel="name" 
                        showClear placeholder="Firma" 
                        class="block w-3/6 md:w-2/6 lg:w-4/6 rounded-lg ml-2"/>
            </div>




            <div class="overflow-hidden w-fit">
                <AddButton v-if="can(['create-user'])" class="rounded-none" @click="data.createOpen = true"></AddButton>
                <Create :show="data.createOpen" @close="data.createOpen = false" :roles="props.roles" :companies="props.companies" :sgks="props.sgks"
                    :title="props.title" />
                <Edit :show="data.editOpen" @close="data.editOpen = false" :user="data.user" :roles="props.roles" :companies="props.companies" :sgks="props.sgks"
                    :title="props.title" />
                <Delete :show="data.deleteOpen" @close="data.deleteOpen = false" :user="data.user" :title="props.title" />
                <ForceDelete :show="data.forceDeleteOpen" @close="data.forceDeleteOpen = false" :user="data.user" :title="props.title" />

                <Upload :show="data.uploadOpen" @close="data.uploadOpen = false" :title="props.title" :user="data.user" :categories="props.categories"/>
                <SendMail :show="data.sendMailOpen" @close="data.sendMailOpen = false" :title="props.title" :user="data.user"/>
                <Export :show="data.createExport" @close="data.createExport = false" :title="props.title" :selectedId="data.selectedId"/>

                <!-- <DeleteBulk :show="data.deleteBulkOpen" @close="
                    (data.deleteBulkOpen = false),
                    (data.multipleSelect = false),
                    (data.selectedId = [])
                    " :selectedId="data.selectedId" :title="props.title" /> -->
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="relative bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="flex justify-between p-2 items-center">
                    <div class="flex space-x-2 items-center">
                        <SelectInput v-model="data.params.perPage" :dataSet="data.dataSet" /> 
                        <div class="text-sm text-gray-500">/ {{ count }}</div>
                    </div>  

                    <Button v-if="can(['view-user']) && data.selectedId.length && ! data.params.trashed" 
                        class="rounded-none" @click="data.createExport = true" severity="warn" size="small" variant="outlined">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25" />
                        </svg>
                        Dışa Aktar ({{ data.selectedId.length  }} / {{ props.users.data.length }})
                    </Button>

                    <div v-if="can(['delete-user'])">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input id="trashed" type="checkbox" class="sr-only peer" v-model="data.params.trashed">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
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
                        <thead class="uppercase text-sm border-t border-slate-200">
                            <tr class="dark:bg-slate-900/50 text-left">
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <input
                                        v-if="can(['create-user']) && ! data.params.trashed"
                                        class="rounded dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-primary dark:text-primary shadow-sm focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                                        type="checkbox"
                                        :checked="'checked' ? data.allSelected : ''" 
                                        @change="selectAll"
                                        v-model="data.allSelected"
                                    />
                                </th>
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    @click="order('name')">
                                    <div class="flex justify-between items-center">
                                        <span>{{ lang().label.name }}</span>
                                        <ChevronUpDownIcon class="w-4 h-4" />
                                    </div>
                                </th>
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    @click="order('company')">
                                    <!-- <div class="flex justify-between items-center">
                                        <span>{{ lang().label.company }}</span>
                                        <ChevronUpDownIcon class="w-4 h-4" />
                                    </div> -->
                                </th>
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- <div class="flex justify-between items-center">
                                        <span>{{ lang().label.role }}</span>
                                    </div> -->
                                </th>
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    @click="order('created_at')">
                                    <div class="flex justify-between items-center">
                                        <span>{{ lang().label.created }}</span>
                                        <ChevronUpDownIcon class="w-4 h-4" />
                                    </div>
                                </th>
                                <th class="px-6 py-3 cursor-pointer border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    @click="order('sgk')">
                                    <div class="flex justify-between items-center">
                                        <span>{{ lang().label.sgk }}</span>
                                        <ChevronUpDownIcon class="w-4 h-4" />
                                    </div>
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>

                        <tbody v-if="users.data.length" class="bg-white text-sm text-gray-700">
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="whitespace-nowrap text-gray-400 py-4 px-2 sm:py-3 text-center border-b border-gray-200">
                                    <input
                                        v-if="can(['create-user']) && ! data.params.trashed"
                                        class="rounded dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-primary dark:text-primary shadow-sm focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                                        type="checkbox"
                                        :value="user.id"
                                        v-model="data.selectedId"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-blue-800 font-medium">
                                    <Link v-if="user && ! data.params.trashed" :href="route('users.show', [user.id])" >
                                        <span class="flex">
                                            {{ user?.name }}
                                                <svg v-if="user.email_verified_at !== null" class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" v-tooltip="lang().tooltip.verified">
                                                <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                                                <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                                                </svg>
                                        </span>
                                    </Link>
                                    
                                    <div v-else class="text-gray-800">
                                        <span class="flex">
                                            {{ user?.name }}
                                                <svg v-if=" user.email_verified_at !== null" class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" v-tooltip="lang().tooltip.verified">
                                                <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                                                <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                                                </svg>
                                        </span>
                                    </div>
                                    <div class="text-sm font-normal leading-5 text-gray-500">{{ user?.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ user.company?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-gray-500">
                                    {{ user.roles?.map(pluck('name'))[0]}}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ user.created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ user.sgk?.name}}
                                </td>
                                <td class="whitespace-nowrap py-4 px-2 sm:py-3 border-b border-gray-200">
                                    <div class="flex justify-center items-center">
                                        <div v-if="! data.params.trashed" class="rounded-md overflow-hidden">
                                            <MailButton v-if="can(['create-mail'])" type="button" @click="
                                                (data.sendMailOpen = true),
                                                (data.user = user)"
                                                v-tooltip="lang().tooltip.email">
                                                <EnvelopeIcon class="w-4 h-4" />
                                            </MailButton>
                                            
                                            <SecondaryButton v-if="can(['create-document'])" type="button" @click="
                                                (data.uploadOpen = true),
                                                (data.user = user)" 
                                                v-tooltip="lang().tooltip.upload">
                                                <ArrowUpIcon class="w-4 h-4" />
                                            </SecondaryButton>
                                            
                                            <InfoButton v-if="can(['update-user'])" type="button" @click="
                                                (data.editOpen = true),
                                                (data.user = user)" 
                                                v-tooltip="lang().tooltip.edit">
                                                <PencilIcon class="w-4 h-4" />
                                            </InfoButton>

                                            <DangerButton v-if="can(['delete-user'])" type="button" @click="
                                                (data.deleteOpen = true),
                                                (data.user = user)" 
                                                v-tooltip="lang().tooltip.delete">
                                                <TrashIcon class="w-4 h-4" />
                                            </DangerButton>
                                        </div>

                                        <div v-if="data.params.trashed" class="rounded-md overflow-hidden">
                                            <SecondaryButton v-if="can(['delete-user'])" type="button" @click="
                                                restore (user)" 
                                                v-tooltip="lang().tooltip.restore">
                                                <ArrowLeftIcon class="w-4 h-4" />
                                            </SecondaryButton>
                                            <DangerButton v-if="can(['delete-user'])" type="button" @click="
                                                (data.forceDeleteOpen = true),
                                                (data.user = user)"
                                                v-tooltip="lang().tooltip.delete
        ">
                                                <XMarkIcon class="w-4 h-4" />
                                            </DangerButton>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        
                        <tr v-else>
                            <td class="whitespace-nowrap text-gray-600 py-4 px-2 sm:py-3 text-center border-b border-gray-200">
                                Herhangi bir kayıt bulunamadı.
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="flex justify-between items-center p-2 border-t border-slate-200">
                    <pagination class="mt-6" :links="users.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
