<template>
  <div
    class="w-full min-h-[30rem] shadow-md rounded-sm"
    :class="{ 'animate-fade-in-scale': active }"
  >
    <iframe
      ref="iframe"
      class="w-full min-h-[30rem] rounded-sm transition-[height] duration-100"
      :srcdoc="email.body"
      @load="adjustHeight"
    />
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import { useTemplateRef } from 'vue';

defineProps({
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

const iframe = useTemplateRef('iframe');

const adjustHeight = () => {
  if (!iframe.value || !iframe.value.contentWindow) {
    return;
  }

  const height = iframe.value.contentWindow.document.body.scrollHeight as number;
  iframe.value.style.height = `${height.toString()}px`;
};
</script>
