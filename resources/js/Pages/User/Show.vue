<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router} from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import BadgeLink from "@/Components/BadgeLink.vue";
import Edit from "@/Pages/User/Edit.vue";
import {
    PencilIcon,
} from "@heroicons/vue/24/solid";
import { reactive } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    title: String,
    mustVerifyEmail: Boolean,
    status: String,
    title: String,
    user: Object,
    roles: Object,
    companies: Object,
    categories: Object,
    sgks: Object,
    lastLogin: String,
    breadcrumbs: Object,
    auth: Object
});

const data = reactive({
        params: {
            selectedYear: false,
            category: 1
        },
    editOpen: false,
    user: null,
});

const verification_send = () => {

    router.post(route('verification.send'), {
        preserveScroll: true,
        onSuccess: () => {
        },
        onError: () => null,
        onFinish: () => null,
    });
}

const navigate = (category) => {
    data.params.category = category.id,

    router.get(route('documents.index', [props.user.id, data.params]), {
        preserveScroll: true,
        onSuccess: () => {
        },
        onError: () => null,    
        onFinish: () => null,
    });
}


</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <Breadcrumb :title="lang().label.user" :breadcrumbs="breadcrumbs" />
        
        <Edit :show="data.editOpen" @close="data.editOpen = false" :user="data.user" :roles="roles" :companies="companies" :sgks="sgks"
                    :title="title" />
                    
        <div class="flex flex-col gap-3 pb-6">
            <div>
                <h3 class="text-2xl text-slate-900 relative font-bold leading-6">
                    <span class="flex">
                        {{ user?.name }} <svg v-if="props.mustVerifyEmail && user.email_verified_at != null" class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" v-tooltip="lang().tooltip.verified">
                            <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                            <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                            </svg>
                    </span>
                </h3>
                <span class="flex">
                    <p class="text text-gray-600">{{ user.email }}</p>
                    <button  v-if="props.mustVerifyEmail && user.email_verified_at === null" @click="verification_send" 
                        class="text pl-2 text-blue-600"> Doğrula </button>
                </span> 
                <div class="italic text-sm text-gray-500">  {{ user.company?.name }}</div>
                <p v-if="lastLogin" class="text-sm text-gray-600">Son Giriş: {{ lastLogin }}</p>
            </div>

            <div v-show="can(['update-user'])" class="flex justify-end">
                <PrimaryButton 
                    @click="(data.editOpen = true), (data.user = user)" v-tooltip="lang().tooltip.edit" class="mr-2">
                    <PencilIcon class="w-4 h-4 mr-2" />
                    Düzenle
                </PrimaryButton> 
                
                
                <BadgeLink :href="route('users.activities', [user.id])" v-tooltip="lang().tooltip.etkinlikler">
                    Son Etkinlikler
                </BadgeLink> 
            </div>                   

            <div class="card">
                <Tabs value="0" scrollable>
                    <TabList>
                        <Tab v-for="category in categories" @click="navigate(category)" :key="category.id" :value="category.name"> {{category.name}} </Tab>
                    </TabList>
                </Tabs>
            </div>


            <h4 class="text-md font-medium leading-3 mt-4">Temel Bilgiler</h4>
            <div class="flex flex-col gap-3">
                <div v-if="can(['view-user'])" class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.company }}
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.company?.name }}
                    </p>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.identity }}
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.identity}}
                    </p>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.recruitment_date }}
                        </p>
                        <!-- <span class="text-xs text-slate-600">5 years</span> -->
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.recruitment_date}}
                    </p>
                </div>

                <!-- <div v-if="can(['view-user'])" class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.sgk }}
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.sgk.name}}
                    </p>
                </div> -->
                
                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.gsm }}
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.gsm}}
                    </p>
                </div>
                
                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            IBAN
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.iban}}
                    </p>
                </div>
                
                <!-- <div v-if="can(['view-user'])" class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.role }}

                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user?.roles == 0 ? "" : user.roles[0].name}}
                    </p>
                </div> -->

                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded border w-full">
                    <div class="leading-3">
                        <p class="text-sm font-bold text-slate-700">
                            {{ lang().label.holidays }}
                        </p>
                    </div>
                    <p class="text-sm text-slate-500 self-start ml-auto">
                        {{ user.holidays}}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
