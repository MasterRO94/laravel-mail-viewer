<template>
  <div
    v-tw-merge
    class="
      flex justify-between py-2 px-2 border-l-4 border-l-transparent cursor-pointer transition-all
      text-gray-700 dark:text-gray-200 hover:bg-slate-200/80 dark:hover:bg-slate-600/50
      hover:border-l-teal-500/50
    "
    :class="{
      'border-l-teal-500 dark:border-l-teal-500 bg-slate-200/80 dark:bg-slate-600/40 hover:border-l-teal-500': active,
    }"
    @click="$emit('selected')"
  >
    <div class="flex flex-col gap-1">
      <div
        class="text-sm"
        v-text="email.subject"
      />

      <Recipients
        :email
        field="to"
      />
    </div>

    <div class="flex flex-col gap-1 text-xs">
      <p v-text="email.formattedDate" />
      <p v-text="email.formattedTime" />
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import Recipients from '@/components/Common/Recipients.vue';

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

defineEmits(['selected']);
</script>
