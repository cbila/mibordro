<script setup>
import KVKK from '@/Pages/Partials/KVKK.vue';
import Sartlar from '@/Pages/Partials/Sartlar.vue';
import About from '@/Pages/Partials/About.vue';
import Policy from '@/Pages/Partials/Policy.vue';
import Cookie from '@/Pages/Partials/Cookie.vue';
import { reactive } from "vue";


const data = reactive({
    sartlarOpen: false,
    KVKKOpen: false,
    aboutOpen: false,
    policyOpen: false,
    cookieOpen: false,
});

</script>


<template>

    <footer class="w-full text-gray-700 bg-gray-100 body-font">
        <KVKK :show="data.KVKKOpen" @close="data.KVKKOpen = false"/>
        <Sartlar :show="data.sartlarOpen" @close="data.sartlarOpen = false"/>
        <About :show="data.aboutOpen" @close="data.aboutOpen = false"/>
        <Policy :show="data.policyOpen" @close="data.policyOpen = false"/>
        <Cookie :show="data.cookieOpen" @close="data.cookieOpen = false"/>
        <div
            class="container flex flex-col flex-wrap px-5 py-24 mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap">
            <div class="flex-shrink-0 w-64 mx-auto text-center md:mx-0 md:text-left">
                <a class="flex items-center justify-center font-medium text-gray-900 title-font md:justify-start">
                    <img src = "img/lets-encrypt-seeklogo.svg" alt="My Happy SVG" width="100" height="100"/>
                </a>
                <!-- <p class="mt-2 text-sm text-gray-500">Tasarım!</p> -->
                <div class="mt-4">
                    <!-- <span class="inline-flex justify-center mt-2 sm:ml-auto sm:mt-0 sm:justify-start">
                        <a class="text-gray-500 cursor-pointer hover:text-gray-700">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                </path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
                                <path stroke="none"
                                    d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z">
                                </path>
                                <circle cx="4" cy="4" r="2" stroke="none"></circle>
                            </svg>
                        </a>
                    </span> -->
                </div>
            </div>


            
            <div class="flex flex-wrap flex-grow mt-10 -mb-10 text-center md:pl-20 md:mt-0 md:text-left">
                <div class="w-full px-4 lg:w-1/4 md:w-1/2">
                    <nav class="mb-10 list-none">
                        <li class="mt-3">
                            <a @click="data.KVKKOpen = true" class="text-blue-800 cursor-pointer hover:underline">KVKK</a>
                        </li>
                        <li class="mt-3">
                            <a @click="data.sartlarOpen = true" class="text-blue-800 cursor-pointer hover:underline">Kullanım Koşulları ve Gizlilik</a>
                        </li>                        
                        <li class="mt-3">
                            <a @click="data.policyOpen = true" class="text-blue-800 cursor-pointer hover:underline">Gizlilik Politikamız</a>
                        </li>
                        <li class="mt-3">
                            <a @click="data.cookieOpen = true" class="text-blue-800 cursor-pointer hover:underline">Çerez Politikamız</a>
                        </li>

                    </nav>
                </div>
                <!-- <div class="w-full px-4 lg:w-1/4 md:w-1/2">
                    <h2 class="mb-3 text-sm font-medium tracking-widest text-gray-900 uppercase title-font">Support</h2>
                    <nav class="mb-10 list-none">
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">Contact Support</a>
                        </li>
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">Help Resources</a>
                        </li>
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">Release Updates</a>
                        </li>
                    </nav>
                </div>
                <div class="w-full px-4 lg:w-1/4 md:w-1/2">
                    <h2 class="mb-3 text-sm font-medium tracking-widest text-gray-900 uppercase title-font">Platform
                    </h2>
                    <nav class="mb-10 list-none">
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">Terms &amp; Privacy</a>
                        </li>
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">Pricing</a>
                        </li>
                        <li class="mt-3">
                            <a class="text-gray-500 cursor-pointer hover:text-gray-900">FAQ</a>
                        </li>
                    </nav>
                </div>-->
                <div class="w-full px-4 lg:w-1/4 md:w-1/2">
                    <h2 class="mb-3 text-sm font-medium tracking-widest text-gray-900 uppercase title-font">İletişim</h2>
                    <nav class="mb-10 list-none">
                        <li class="mt-3">
                            <p class="text-gray-500">Ataşehir Atatürk Mahallesi
                            Defne Sokak
                            </p>
                        </li>
                        <li class="mt-3">
                            <p class="text-gray-500">My Towerland 3381-3 C1 D134 Ataşehir İstanbul Türkiye</p>
                        </li>
                        <li class="mt-3">
                            <p class="text-gray-500">0850 255 00 82</p>
                        </li>

                    </nav>
                </div>                 
                <div class="w-full px-4 lg:w-1/4 md:w-1/2">
                    <h2 class="mb-3 text-sm font-medium tracking-widest text-gray-900 uppercase title-font">YASAL</h2>
                    <nav class="mb-10 list-none">
 
                        <li class="mt-3">
                            <p class="text-gray-500">
                                Mibordro Yönetim platformu bir 
                                <a href="https://mi.com.tr" target="_blank" class="text-blue-800 hover:underline"> Metropol International İnsan Kaynakları A.Ş </a>
                                kurluşudur, Türkiye İş Kurumu’nun 07/10/2021 tarih ve 202 numaralı ‘Özel İstihdam Bürosu İzin Belgesi’ ile faaliyet göstermektedir. Özel İstihdam Bürosu İzin Belgesi Çalışma ve İş Kurumu İstanbul İl Müdürlüğü’nce düzenlenmiştir. 4904 sayılı Kanun uyarınca iş arayandan ücret alınması yasaktır.
                            </p>
                        </li>
                    </nav>
                </div> 
            </div>
        </div>
        <div class="bg-gray-300">
            <div class="container px-5 py-4 mx-auto">
                <p class="text-sm text-gray-700 capitalize xl:text-center">© 2020 Tüm hakları saklıdır. </p>
            </div>
        </div>
    </footer>
</template>