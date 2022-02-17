<template>
  <div class="flex justify-between">
    <div
      class="text-xs max-w-sm group-hover:text-white"
      :class="isActive ? 'text-white' : 'text-slate-500'"
    >
      <div
        v-for="(recipients, key) of {to: email.to}"
        :key="`email-${email.id}-${key}`"
        v-show="recipients.length"
      >
        <strong
          class="capitalize"
          v-text="`${key}:`"
        />
        &nbsp;
        <template
          v-for="(recipient, i) of recipients"
          :key="`email-${email.id}-${key}-${recipient.email}`"
        >
          <span
            v-if="recipient.name"
          >
           {{ recipient.name }}
           &lt;<span class="mail-item-email">{{ recipient.email }}</span>&gt;{{ i < recipients.length - 1 ? ',' : '' }}
          </span>
          <span
            v-else
          >
            <span class="mail-item-email">{{ recipient.email }}</span>{{ i < recipients.length - 1 ? ',' : '' }}
          </span>
          &nbsp;
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    email: {
      type: Object,
      required: true,
    },

    isActive: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
};
</script>
