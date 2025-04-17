<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon,  XMarkIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    auth: Object,
    company: Object,

});

const navigation = [
    { name: 'Anasayfa', href: 'dashboard', current: true, permission: '' },
    { name: 'Şirket', href: 'company', current: false, permission: 'view-company' },
    { name: 'Kullanıcı', href: 'users', current: false, permission: 'view-user' },
    { name: 'SGK', href: 'sgk', current: false, permission: 'view-sgk'  },
    { name: 'Kategori', href: 'category', current: false, permission: 'view-category'},
    { name: 'Kayıt', href: 'activities', current: false, permission: 'view-activity' },
];

</script>

<script>
export default {
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        }
    }
}
</script>

<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Ana Menü</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-10 w-auto" src="/img/250x63tw.png" alt="Metropol İnsan Kaynakları" />
                    </div>

                    <div class="hidden sm:ml-6 sm:block">
                        <div class="ml-12 flex space-x-4">
                            <Link v-for="item in navigation" :key="item.name" :href="`/${item.href}`"
                                v-show="can([`${item.permission}`]) || (item.href == 'dashboard')"
                                :class="[isUrl(item.href) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                :aria-current="isUrl(item.href) ? 'page' : undefined">{{ item.name }}
                            </Link>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative ml-3 mr-6">
                        <div>
                            <MenuButton class="relative flex">
                                <span class="absolute -inset-1.5" />
                                <span class="text-white">{{ auth.user.name }}</span>

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </MenuButton>
                            <!-- <div class="text-gray-400 hidden lg:block mr-6">{{ $page.props.company.name }}</div> -->
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

                                <div class="text-center text-gray-500">{{ auth.user.roles[0].name }}</div>
                                
                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('users.show', auth.user.id)"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                        Profilim
                                    </Link>
                                </MenuItem>

                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('profile.edit', auth.user.id)"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                        Profilimi Düzenle
                                    </Link>
                                </MenuItem>

                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('logout')"
                                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                        method="post" as="link">
                                        {{ lang().label.logout }}
                                    </Link>
                                </MenuItem>

                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="`/${item.href}`"
                    v-show="can([`${item.permission}`]) || (item.href == 'dashboard')"
                    :class="[isUrl(item.href) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                    :aria-current="isUrl(item.href) ? 'page' : undefined">
                    {{ item.name }}
                </DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
