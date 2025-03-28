<template>
  <div
    class="w-full min-h-[20rem] p-2 space-y-2"
    :class="{ 'animate-fade-in': active }"
  >
    <p
      v-for="(value, header) in email.headers"
      :key="`email-${email.id}-header-${header}`"
    >
      <strong v-text="`${header}:`" />
      <span v-text="value" />
    </p>
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
