<template>
  <div
    class="w-full min-h-[20rem] p-2"
    :class="{ 'animate-fade-in': active }"
  >
    <p v-text="email.text" />
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';

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
</script>
