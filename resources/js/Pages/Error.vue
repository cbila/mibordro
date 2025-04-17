<script setup>
import ExceptionLayout from '@/Layouts/ExceptionLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  status: Number,
  message: String
});

</script>

<template>  
    <ExceptionLayout>
  <div>
      <h1 class="text-xl m-6">Beklenmeyen bir hata oluştu.</h1>

      <h1>Hata Kodu: {{ status }}</h1>

      <p>Hata Mesajı: {{ message }}</p>


      <Link :href="route('dashboard')">
        <h2 class="text-xl text-blue-700 mt-6">Anasayfa</h2>
      </Link>
      

  </div>
</ExceptionLayout>

</template>