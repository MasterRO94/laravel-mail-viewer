<template>
  <div class="font-primary flex min-h-dvh w-full">
    <Sidebar @selected="(email: Email) => (activeEmail = email)" />

    <MainSection :email="activeEmail" />

    <ThemeToggler />
  </div>
</template>

<script
  setup
  lang="ts"
>
import { onBeforeMount, ref } from 'vue';
import Sidebar from '@/components/Sidebar/Sidebar.vue';
import MainSection from '@/components/Main/MainSection.vue';
import Email from '@/models/Email';
import ThemeToggler from '@/components/Common/ThemeToggler.vue';

const activeEmail = ref<Email | null>(null);

const theme: string = localStorage.getItem('color-theme') || 'dark';

onBeforeMount(() => {
  if (theme === 'dark') {
    document.body.classList.add('dark');
  }
});
</script>
