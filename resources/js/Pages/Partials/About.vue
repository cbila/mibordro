<script setup>
import Modal from "@/Components/Modal.vue";

const emit = defineEmits(["close"]);

const props = defineProps({
    show: Boolean,

});


</script>


<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">
            <div class="p-6">


            </div>
        </Modal>
    </section>
</template>