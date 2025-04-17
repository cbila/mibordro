<script setup>
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
// import InputLabel from "@/Components/InputLabel.vue";


const emit = defineEmits(["close"]);

let submitted = false;

const form = useForm({
    name: "",
    email: "",
    subject: "",
    message: "",

});


const send = () => {
    form.post(route("contact.store"), {
        preserveScroll: true,
        onSuccess: () => {
            submitted = true;
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
};

</script>


<template>
    <section id="contact" class="bg-white dark:bg-gray-900">
        <div class="py-6 lg:py-12 px-4 mx-auto max-w-screen-md">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Size ulaşalım
            </h2>
            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Soru, yardım, görüş ve önerileriniz için lütfen bize yazın</p>
            
            <div @close="submitted=true" v-if="submitted">
                <p class="text-red-700 font-bold text-lg">Mesajınız başarıyla iletildi. 
                    Size en kısa zamanda dönüş yapılacaktır. Bizimle iletişime geçtiğiniz için teşekkür ederiz.</p>
            </div>
            
            <form v-else="submitted" href="#" action.prevent="" class="space-y-4">
                <div class="mt-2">
                    <!-- <InputLabel for="name" :value="lang().label.name" /> -->
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        :placeholder="lang().placeholder.name"
                        :error="form.errors.name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="mt-2">
                    <!-- <InputLabel for="email" :value="lang().label.email" /> -->
                    <TextInput
                        id="email"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        :placeholder="lang().placeholder.email"
                        :error="form.errors.email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mt-2">
                    <!-- <InputLabel for="subject" :value="lang().label.subject" /> -->
                    <TextInput
                        id="subject"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.subject"
                        required
                        :placeholder="lang().placeholder.subject"
                        :error="form.errors.subject"
                    />
                    <InputError class="mt-2" :message="form.errors.subject" />
                </div>
                <div class="mt-2">
                    <!-- <InputLabel for="message" :value="lang().label.message" /> -->
                    <TextArea
                        id="message"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.message"
                        required
                        :placeholder="lang().placeholder.message"
                        :error="form.errors.message"
                    />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <PrimaryButton
                        class=""
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="send"
                    >                        {{
                    form.processing
                                ? lang().button.send + "..."
                                : lang().button.send
                        }}
                </PrimaryButton>
            </form>
        </div>
    </section>
</template>