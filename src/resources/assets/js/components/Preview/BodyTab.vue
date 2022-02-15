<template>
  <tab name="Body">
    <div class="p-3 bg-gray-200 rounded min-h-screen">
      <pre
        v-text="email.payload"
        class="text-slate-800 overflow-auto"
      />
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
