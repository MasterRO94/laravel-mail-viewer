<template>
  <div
    class="w-full min-h-[30rem] shadow-md rounded-sm"
    :class="{ 'animate-fade-in': active }"
  >
    <div class="w-full max-w-full overflow-x-auto">
      <div
        class="rounded-sm overflow-hidden"
        v-html="source"
      />
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import { ref, watch } from 'vue';
import { codeToHtml } from 'shiki';

const { email } = defineProps({
  email: {
    type: Email,
    required: true,
  },

  active: {
    type: Boolean,
    required: false,
    default: false,
  },
});

const source = ref(email.body);

watch(() => email, async (newEmail: Email) => {
  source.value = await codeToHtml(newEmail.body, {
    lang: 'html',
    themes: {
      dark: 'material-theme-palenight',
      light: 'material-theme-lighter',
    },
  });
}, { immediate: true });
</script>
