<template>
  <div>
    <div class="mb-4">
      <Link v-show="can(['view-role'])" class="group flex items-center py-3" href="/role">
        <icon name="role" class="mr-2 w-4 h-4"
          :class="isUrl('role') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('role') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{lang().label.role}}</div>
        </Link>

      <Link v-show="can(['view-permission'])" class="group flex items-center py-3" href="/permission">
        <icon name="permission" class="mr-2 w-4 h-4"
          :class="isUrl('permission') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('permission') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{lang().label.permission}}</div>
        </Link>
    </div>




  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  props: ['selected_site'],

  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
