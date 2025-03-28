<template>
  <div
    v-tw-merge
    class="text-xs flex flex-wrap items-center gap-x-1"
  >
    <strong
      v-show="displayFieldName"
      class="capitalize"
    >
      {{ field }}:
    </strong>

    <template
      v-for="(recipient, i) of email[field]"
      :key="`${recipient.email}-${i}`"
    >
      <span
        v-if="recipient.name"
        class="text-slate-700 dark:text-gray-200"
      >
        {{ recipient.name }}
        &lt;<component
        :is="linkAddress ? 'a' : 'span'"
        :href="`mailto:${recipient.email}`"
        class="text-teal-500"
      >{{ recipient.email }}</component>&gt;{{ i < email[field].length - 1 ? ',' : '' }}
      </span>

      <span
        v-else
      >
        <component
          :is="linkAddress ? 'a' : 'span'"
          :href="`mailto:${recipient.email}`"
          class="text-teal-500"
        >{{ recipient.email }}</component>{{ i < email[field].length - 1 ? ',' : '' }}
      </span>
    </template>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import { RecipientEmailField } from '@/types';

const { email, field, displayFieldName = false, linkAddress = false } = defineProps<{
  email: Email,
  field: RecipientEmailField,
  displayFieldName?: boolean,
  linkAddress?: boolean,
}>();
</script>
