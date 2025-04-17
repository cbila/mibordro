import './bootstrap';
import '../css/app.css';
import 'floating-vue/dist/style.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';


import FloatingVue from 'floating-vue'
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import VueGtag from "vue-gtag";
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
// import 'primevue/resources/themes/aura-light-green/theme.css'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

if (process.env.NODE_ENV === "production") {
    router.on('navigate', (event) => {
        gtag("js", new Date());
        gtag("config", "G-M6KPQBFMB8");
    })
}


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(FloatingVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: 'p',
                        darkModeSelector: 'none',
                        cssLayer: false
                    }
                },
                locale: {
                    dayNamesMin:	['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
                    dayNamesShort: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'],
                    monthNamesShort: ['Oca', 'Şbt', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara'],
                    dayNames:	['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                    monthNames:	['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
                }
            })
            .use(VueGtag)
            .mixin({
                methods: {
                    can: function (permissions) {
                        var allPermissions = this.$page.props.auth.can;
                        var hasPermission = false;
                        permissions.forEach(function (item) {
                            if (allPermissions[item]) hasPermission = true;
                        });
                        return hasPermission;
                    },
                    lang: function () {
                        return usePage().props.language.original;
                    }
                },
            })
            .mount(el);
            
    },
    progress: {
        color: '#4B5563',
    },
});



// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, App, props, plugin }) {
//         return createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .use(FloatingVue)
//             .use(PrimeVue)
//             .use(VueGtag)
//             .mixin({
//                 methods: {
//                     can: function (permissions) {
//                         var allPermissions = this.$page.props.auth.can;
//                         var hasPermission = false;
//                         permissions.forEach(function (item) {
//                             if (allPermissions[item]) hasPermission = true;
//                         });
//                         return hasPermission;
//                     },
//                     lang: function () {
//                         return usePage().props.language.original;
//                     }
//                 },
//             })
//             .mount(el);
//     },
//     progress: {
//         color: '#0284c7',
//     },
// });
