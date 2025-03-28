<template>
  <div class="mt-8">
    <EmailDetailsHeader :email />
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import EmailDetailsHeader from '@/components/Main/EmailDetailsHeader.vue';

defineProps({
  email: {
    type: Email,
    required: true,
  },
});
</script>
