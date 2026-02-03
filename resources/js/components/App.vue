<template>
  <div class="font-primary flex min-h-dvh w-full">
    <Sidebar />

    <MainSection />

    <ThemeToggler />
  </div>
</template>

<script
  setup
  lang="ts"
>
import { onBeforeMount } from 'vue';
import Sidebar from '@/components/Sidebar/Sidebar.vue';
import MainSection from '@/components/Main/MainSection.vue';
import ThemeToggler from '@/components/Common/ThemeToggler.vue';

const theme: string = localStorage.getItem('color-theme') || 'dark';

onBeforeMount(() => {
  if (theme === 'dark') {
    document.body.classList.add('dark');
  }
});
</script>
