<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import { router} from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const user = usePage().props.auth.user;

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const send_reset_link = () => {

    router.post(route('password.change'), {
        preserveScroll: true,
        onSuccess: () => {
        },
        onError: () => null,
        onFinish: () => null,
    });
}


</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                {{ lang().profile.update_password }}
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400 mb-6">
                Şifre sıfırlayabilmek için öncelikle e-posta adresinizi doğrulamanız gerekmektedir.
            </p>
        </header>

        <DangerButton v-if="props.mustVerifyEmail && user.email_verified_at !== null" class="text-white bg-red-700 hover:bg-red-800 px-5 py-2.5" @click="send_reset_link"> Şifre Yenileme Bağlantısı Gönder </DangerButton>

    </section>
</template>
