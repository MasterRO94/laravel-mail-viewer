<template>
  <tab name="Headers">
    <div class="p-3 bg-gray-200 space-y-2 rounded">
      <p
        v-for="(value, header) in email.headers"
        :key="`email-${email.id}-header-${header}`"
        class="text-slate-800"
      >
        <strong v-text="`${header}:`" />
        <span v-text="value" />
      </p>
    </div>
  </tab>
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
