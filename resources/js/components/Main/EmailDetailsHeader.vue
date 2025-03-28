<template>
  <div>
    <h1 class="text-xl">
      {{ email.subject }}
    </h1>

    <div class="flex flex-col mt-4 gap-1">
      <Recipients
        v-for="field in fields"
        v-show="email[field]?.length"
        :key="`email-${email.id}-${field}`"
        :email
        :field
        display-field-name
        link-address
        class="text-sm"
      />
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import Recipients from '@/components/Common/Recipients.vue';
import { RecipientEmailField } from '@/types';

defineProps({
  email: {
    type: Email,
    required: true,
  },
});

const fields: RecipientEmailField[] = ['to', 'from', 'cc', 'bcc'];
</script>
