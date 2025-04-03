<template>
  <button
    class="
      absolute top-4 right-4 flex justify-center cursor-pointer rounded-md text-slate-700 dark:text-gray-200 transition-colors
      hover:text-teal-500 dark:hover:text-teal-600
    "
    @click="toggleTheme"
  >
    <Transition
      name="fade-switch"
      mode="out-in"
    >
      <IconMoonFilled v-if="theme === 'dark'" />
      <IconSunFilled v-else />
    </Transition>
  </button>
</template>

<script
  setup
  lang="ts"
>
import { ref } from 'vue';
import { IconMoonFilled, IconSunFilled } from '@tabler/icons-vue';

const theme = ref<string>(localStorage.getItem('color-theme') || 'dark');

const toggleTheme = () => {
  theme.value = theme.value === 'dark' ? 'light' : 'dark';

  localStorage.setItem('color-theme', String(theme.value));

  document.body.classList.toggle('dark');
};
</script>

