<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Breadcrumb.vue";

import {
    ChevronRightIcon,
    BuildingOfficeIcon,
    BuildingOffice2Icon,
    ShieldCheckIcon,
    UserIcon,
    ClipboardDocumentListIcon,
    DocumentIcon
} from "@heroicons/vue/24/solid";

const props = defineProps({
    title: String,
    user_count: Number,
    trashed_count: Number,
    company_count: Number,
    role_count: Number,
    permission_count: Number,
    activity_count: Number,
    document_count: Number,
    sgk_count: Number,
    breadcrumbs: Object,
    user: Object,
    categories: Object,
    company: Object,
});


</script>

<template>
    <Head :title="title" />


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Anasayfa</h2>
        </template>

        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />

        
        <div class="space-y-4 pt-4">
            <div class="text-white dark:text-slate-100 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4 overflow-hidden shadow-sm">
                <div v-if="can(['view-user'])">
                    <div  class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-blue-600/70 dark:bg-blue-500/80 items-center overflow-hidden">
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(user_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                {{ lang().label.user }}
                            </p>
                        </div>
                        <div>
                            <UserIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div  class="bg-blue-600 dark:bg-blue-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-blue-600/90 dark:hover:bg-blue-600/70">
                        <Link
                            :href="route('users.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-user'])">
                    <div  class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-orange-600/70 dark:bg-orange-500/80 items-center overflow-hidden">
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(trashed_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                Silinmiş Kullanıcı
                            </p>
                        </div>
                        <div>
                            <UserIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div class="bg-orange-600 dark:bg-orange-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-orange-600/90 dark:hover:bg-orange-600/70">
                        <Link
                            :href="route('users.index', {'trashed': 1})"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-company'])">
                    <div  class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-lime-600/70 dark:bg-lime-500/80 items-center overflow-hidden">                     
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(company_count)}}
                            </p>   
                            <p class="text-md md:text-lg uppercase">
                                {{ lang().label.company }}
                            </p>
                        </div>
                        <div>
                            <BuildingOffice2Icon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div 
                        class="bg-lime-600 dark:bg-lime-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-lime-600/90 dark:hover:bg-lime-600/70"
                    >
                        <Link
                            :href="route('company.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-role'])">
                    <div
                        class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-amber-600/70 dark:bg-amber-500/80 items-center overflow-hidden"
                    >
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(role_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                {{ lang().label.role }}
                            </p>
                        </div>
                        <div>
                            <ShieldCheckIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div
                        class="bg-amber-600 dark:bg-amber-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-amber-600/90 dark:hover:bg-amber-600/70"
                    >
                        <Link
                            :href="route('role.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-permission'])">
                    <div
                        class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-gray-600/70 dark:bg-gray-500/80 items-center overflow-hidden"
                    >
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(permission_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                {{ lang().label.permission }}
                            </p>
                        </div>
                        <div>
                            <ShieldCheckIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div
                        class="bg-gray-600 dark:bg-gray-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-gray-600/90 dark:hover:bg-amber-600/70"
                    >
                        <Link
                            :href="route('permission.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-sgk'])">
                    <div
                        class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-yellow-600/70 dark:bg-yellow-500/80 items-center overflow-hidden"
                    >
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(sgk_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                SGK Müdürlüğü
                            </p>
                        </div>
                        <div>
                            <BuildingOfficeIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div
                        class="bg-yellow-600 dark:bg-yellow-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-yellow-600/90 dark:hover:bg-amber-600/70"
                    >
                        <Link
                            :href="route('sgk.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-if="can(['view-user'])">
                    <div
                        class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-sky-600/70 dark:bg-sky-500/80 items-center overflow-hidden"
                    >
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(document_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                Doküman
                            </p>
                        </div>
                        <div>
                            <DocumentIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    
                    <div
                        class="bg-sky-600 dark:bg-sky-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-sky-600/90 dark:hover:bg-amber-600/70"
                    >
                        <Link
                            href="#"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>

                <div v-if="can(['view-activity'])">
                    <div
                        class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-teal-600/70 dark:bg-teal-500/80 items-center overflow-hidden"
                    >
                        <div class="flex flex-col">
                            <p class="text-4xl font-bold">
                                {{new Intl.NumberFormat('tr-TR').format(activity_count)}}
                            </p>
                            <p class="text-md md:text-lg uppercase">
                                İşlem / Kayıt
                            </p>
                        </div>
                        <div>
                            <BuildingOfficeIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    
                    <div
                        class="bg-teal-600 dark:bg-teal-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-teal-600/90 dark:hover:bg-amber-600/70"
                    >
                        <Link
                            :href="route('activities.index')"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                

            </div>
        </div>


        <div class="space-y-4 pt-10">
            <div class="text-white dark:text-slate-100 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4 overflow-hidden shadow-sm">
                <div>
                    <div class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-green-600/70 dark:bg-green-500/80 items-center overflow-hidden">
                        <div class="flex flex-col">
                            <p class="text-md md:text-lg uppercase">
                                Profilim
                            </p>
                        </div>
                        <div>
                            <UserIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div class="bg-green-600 dark:bg-green-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-green-600/90 dark:hover:bg-green-600/70">
                        <Link
                            :href="route('users.show', user.id)"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>
                <div v-for="category in categories" :key="category.id">
                    <div class="rounded-t-none sm:rounded-t-lg px-4 py-6 flex justify-between bg-indigo-600/70 dark:bg-indigo-500/80 items-center overflow-hidden">
                        <div class="flex flex-col">
                            <p class="text-md md:text-lg uppercase">
                                {{ category.name }}
                            </p>
                        </div>
                        <div>
                            <ClipboardDocumentListIcon class="w-16 h-auto" />
                        </div>
                    </div>
                    <div class="bg-indigo-600 dark:bg-indigo-600/80 rounded-b-none sm:rounded-b-lg p-2 overflow-hidden hover:bg-indigo-600/90 dark:hover:bg-indigo-600/70">
                        <Link
                        :href="route('documents.index', [user.id, {'category': category.id}])"
                            class="flex justify-between items-center"
                        >
                            <p>{{ lang().label.more }}</p>
                            <ChevronRightIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </div>

            </div>
        </div>

    </AuthenticatedLayout

></template>
    