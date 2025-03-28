<template>
  <aside>
    <div class="h-dvh w-[22rem] shrink-0" />
    <div class="fixed top-0 left-0 z-10 inset-1 flex h-dvh w-[22rem] shrink-0 flex-col bg-slate-100 dark:bg-slate-800 shadow-md">
      <SidebarHeader />

      <div class="flex flex-1 flex-col gap-2 min-h-0 overflow-auto">
        <EmailList @selected="(email: Email) => $emit('selected', email)" />
      </div>

      <SidebarFooter />
    </div>
  </aside>
</template>

<script
  setup
  lang="ts"
>
import EmailList from './EmailList.vue';
import SidebarHeader from '@/components/Sidebar/SidebarHeader.vue';
import SidebarFooter from '@/components/Sidebar/SidebarFooter.vue';
import Email from '@/models/Email';

defineEmits<{
  selected: [email: Email],
}>();
</script>
