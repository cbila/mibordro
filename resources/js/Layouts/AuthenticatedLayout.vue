<script setup>

import MainMenu from '@/Shared/MainMenu.vue'
import TopMenu from '@/Shared/TopMenu.vue'
import Toast from "@/Components/Toast.vue";


defineProps({
    auth: Object,
    company: Object,
})

</script>

<template>
    
    <div>
        <TopMenu :auth="$page.props.auth"/>
        <div id="dropdown" />
        <div class="md:flex md:flex-col">
            <div class="md:flex md:flex-col md:h-screen">

                <Toast :flash="$page.props.flash" />

                <div class="md:flex md:flex-grow md:overflow-hidden">
                    <MainMenu class="hidden flex-shrink-0 p-12 w-64 bg-gray-800 overflow-y-auto md:block" />

                    <div class="px-4 py-0 md:flex-1 md:p-12 md:pt-0 md:overflow-y-auto bg-gray-300" scroll-region>
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

