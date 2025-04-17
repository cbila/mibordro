<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    links: Object
});

</script>

<template>
  <div v-if="links.length > 3">
    <div class="inline-flex">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key"
          class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          v-html="link.label" />
        <Link v-else :key="`link-${key}`"
          class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          :class="{ 'bg-blue-400': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

