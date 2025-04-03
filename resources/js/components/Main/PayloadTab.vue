<template>
  <div
    class="w-full min-h-[30rem] shadow-md rounded-sm"
    :class="{ 'animate-fade-in': active }"
  >
    <Loader v-show="loading" />

    <div
      v-if="payload && !loading"
      class="w-full max-w-full overflow-x-auto"
    >
      <div
        class="rounded-sm overflow-hidden"
        v-html="payload"
      />
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import { computed, ref, watch } from 'vue';
import { codeToHtml } from '@/shiki.bundle';
import store from '@/store';
import { fetchEmailPayload } from '@/api';
import Loader from '@/components/Common/Loader.vue';

const { email, active } = defineProps({
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

const loading = ref<boolean>(true);

const payload = computed({
  get() {
    return store.payloads[email.id] ?? null;
  },

  set(value) {
    store.payloads[email.id] = value;

    if (Object.keys(store.payloads).length > 10) {
      // Cleanup cache.
      const keys = Object.keys(store.payloads).filter(key => String(key) !== String(email.id));
      const keyIndex = Math.floor(Math.random() * keys.length);

      // eslint-disable-next-line @typescript-eslint/no-dynamic-delete
      delete store.payloads[keys[keyIndex]];
    }
  },
});

const loadPayload = async () => {
  if (payload.value) {
    loading.value = false;

    return;
  }

  loading.value = true;

  payload.value = await codeToHtml(await fetchEmailPayload(email), {
    lang: 'html',
    themes: {
      dark: 'material-theme-palenight',
      light: 'material-theme-lighter',
    },
  });

  loading.value = false;
};

watch(() => active, (value: boolean) => {
  if (!value) {
    return;
  }

  return loadPayload();
}, { immediate: true });
</script>
