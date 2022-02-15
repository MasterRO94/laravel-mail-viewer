<template>
  <tab name="HTML">
    <div class="p-3 bg-gray-200 rounded">
      <pre
        v-highlightjs
        class="text-slate-800 overflow-auto"
      >
        <code class="html">{{ email.body }}</code>
      </pre>
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
