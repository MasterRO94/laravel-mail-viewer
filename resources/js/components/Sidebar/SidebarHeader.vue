<template>
  <header class="p-2">
    <a
      :href="siteUrl"
      class="flex items-center justify-start rounded-md p-2 text-gray-800 transition-colors hover:bg-slate-200 dark:text-white dark:hover:bg-slate-700"
    >
      <div class="inline-flex shrink grow-0 items-center justify-center rounded-md bg-slate-900 p-1 dark:bg-white">
        <IconMail class="size-8 text-slate-100 dark:text-slate-900" />
      </div>

      <div class="flex flex-col px-4">
        <span
          class="font-semibold"
          v-text="appName"
        />

        <span class="text-sm"> Outbound Emails </span>
      </div>
    </a>
  </header>
</template>

<script
  setup
  lang="ts"
>

import IconMail from '@/components/Icons/IconMail.vue';
const appName = document.querySelector('#app').dataset.appName;
const siteUrl = document.querySelector('#app').dataset.siteUrl;
</script>
