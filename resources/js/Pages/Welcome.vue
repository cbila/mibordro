<script setup>
import { Link } from "@inertiajs/vue3";
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import Contact from '/resources/js/Pages/Partials/Contact.vue';
import Footer from '/resources/js/Pages/Partials/Footer.vue';
// import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const navigation = [
  // { name: "KVKK", href: "#kvkk" },
  // { name: "İletişim", href: "#contact" },
  // { name: "Yardım", href: "help" },
  // { name: "Kullanım Koşulları ve Gizlilik", href: "#kullanim" },
  // { name: "Giriş", href: "login" },
]
</script>

<template>
  <div class="relative overflow-hidden bg-white">
    <div class="mx-auto max-w-7xl">
      <div class="
          relative
          z-10
          bg-white
          pb-8
          sm:pb-16
          md:pb-20
          lg:w-full lg:max-w-2xl lg:pb-28
          xl:pb-32
        ">
        <svg class="
            absolute
            inset-y-0
            right-0
            hidden
            h-full
            w-48
            translate-x-1/2
            transform
            text-white
            lg:block
          " fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
          <polygon points="50,0 100,0 50,100 0,100" />
        </svg>

        <Popover>
          <div class="relative px-4 pt-6 sm:px-6 lg:px-8">
            <nav class="
                relative
                flex
                items-center
                justify-between
                sm:h-10
                lg:justify-start
              " aria-label="Global">
              <div class="flex flex-shrink-0 flex-grow items-center lg:flex-grow-0">
                <div class="flex w-full items-center justify-between md:w-auto">
                  <a href="#">
                    <span class="sr-only">Metropol İnsan Kaynakları</span>
                    <img alt="Metropol İK" class="h-10 w-auto sm:h-16" src="/img/1500x500t.png" />
                  </a>
                  <div class="-mr-2 flex items-center md:hidden">
                    <!-- <PopoverButton class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-md
                        bg-white
                        p-2
                        text-gray-400
                        hover:bg-gray-100 hover:text-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-inset
                        focus:ring-indigo-500
                      ">
                      <span class="sr-only">Open main menu</span>
                      <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                    </PopoverButton> -->
                  </div>
                </div>
              </div>
              <div class="hidden md:ml-6 md:block md:space-x-4 md:pr-0">
                <Link v-for="item in navigation" :key="item.name" :href="item.href"
                  class="font-medium text-gray-500 hover:text-gray-900">{{ item.name }}
                </Link>

              </div>
            </nav>
          </div>

          <!-- <transition enter-active-class="duration-150 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <PopoverPanel focus class="
                absolute
                inset-x-0
                top-0
                z-10
                origin-top-right
                transform
                p-2
                transition
                md:hidden
              ">
              <div class="
                  overflow-hidden
                  rounded-lg
                  bg-white
                  shadow-md
                  ring-1 ring-black ring-opacity-5
                ">
                <div class="flex items-center justify-between px-5 pt-4">
                  <div>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                      alt="" />
                  </div>
                  <div class="-mr-2">
                    <PopoverButton class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-md
                        bg-white
                        p-2
                        text-gray-400
                        hover:bg-gray-100 hover:text-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-inset
                        focus:ring-indigo-500
                      ">
                      <span class="sr-only">Close main menu</span>
                      <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </PopoverButton>
                  </div>
                </div>
                <div class="space-y-1 px-2 pt-2 pb-3">
                  <Link v-for="item in navigation" :key="item.name" :href="item.href" class="
                      block
                      rounded-md
                      px-3
                      py-2
                      text-base
                      font-medium
                      text-red-700
                      hover:bg-gray-50 hover:text-gray-900
                    ">{{ item.name }}</Link>

                </div>
              </div>

            </PopoverPanel>
          </transition> -->
        </Popover>

        <main class="
            mx-auto
            mt-10
            max-w-7xl
            px-4
            sm:mt-12 sm:px-6
            md:mt-16
            lg:mt-20 lg:px-8
            xl:mt-28
          ">
          <div class="sm:text-center lg:text-left">
            <h1 class="
                text-4xl
                font-bold
                tracking-tight
                text-gray-900
                sm:text-5xl
                md:text-6xl
              ">
              <span class="block xl:inline">Metropol International</span>
              {{ " " }}
              <span class="block text-indigo-600 xl:inline">Bordro Yönetimi Platformu</span>
            </h1>
            <div class="
                mt-3
                text-base text-gray-500
                sm:mx-auto sm:mt-5 sm:max-w-xl sm:text-lg
                md:mt-5 md:text-xl
                lg:mx-0
              ">
                <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      Bordro görüntüleme ve zaman damgalı arşivleme
                  </li>
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      Kişisel bilgiler ve özlük dosyaları yönetimi
                  </li>
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      İzin formları yönetimi
                  </li>
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      %100 güvenlik
                  </li>
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      Kolay kullanım
                  </li>
                  <li class="flex items-center">
                      <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                      </svg>
                      7/24 erişim
                  </li>
                </ul>          
            </div>
            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
              <div class="rounded-md shadow">
                <a href="login" class="
                    flex
                    w-full
                    items-center
                    justify-center
                    rounded-md
                    border border-transparent
                    bg-indigo-600
                    px-8
                    py-3
                    text-base
                    font-medium
                    text-white
                    hover:bg-indigo-700
                    md:py-4 md:px-10 md:text-lg
                  ">Üye Girişi</a>
              </div>
              <!-- <div class="mt-3 sm:mt-0 sm:ml-3">
                <a href="register" class="
                    flex
                    w-full
                    items-center
                    justify-center
                    rounded-md
                    border border-transparent
                    bg-indigo-100
                    px-8
                    py-3
                    text-base
                    font-medium
                    text-indigo-700
                    hover:bg-indigo-200
                    md:py-4 md:px-10 md:text-lg
                  ">Kayıt Ol</a>
              </div> -->
            </div>
          </div>
        </main>
      </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
      <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:h-full lg:w-full"
        src="img/gorsel3.jpg"
        alt="" />
    </div>
  </div>



  <Contact></Contact>

  <Footer></Footer>
</template>
