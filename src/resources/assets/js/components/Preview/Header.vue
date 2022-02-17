<template>
  <section class="mb-4 preview-header">
    <div
      class="text-2xl text-gray-700"
      v-text="email.subject"
    />

    <div
      v-for="(recipients, key) of {from: email.from, to: email.to, cc: email.cc, bcc: email.bcc}"
      :key="`currentEmail-${email.id}-${key}`"
      v-show="recipients.length"
    >
      <strong
        class="capitalize text-gray-700"
        v-text="`${key}: `"
      />

      <span
        class=""
        v-for="(recipient, i) of recipients"
        :key="`currentEmail-${email.id}-${key}-${recipient.email}`"
      >
        <span
          v-if="recipient.name"
        >
          <span class="text-gray-700">
            {{ recipient.name }}
          </span>
          &lt;<a
            :href="`mailto:${recipient.email}`"
            target="_blank"
            class="mail-item-email hover:underline"
        >{{ recipient.email }}</a>&gt;{{ i < recipients.length - 1 ? ',' : '' }}&nbsp;
        </span>

        <span
          v-else
        >
          <a
            :href="`mailto:${recipient.email}`"
            target="_blank"
            class="mail-item-email hover:underline"
          >{{ recipient.email }}</a>{{ i < recipients.length - 1 ? ',' : '' }}&nbsp;
        </span>
      </span>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    email: {
      type: Object,
      required: true,
    },
  },
};
</script>
