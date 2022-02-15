<template>
  <tab name="Preview">
    <div class="w-full">
      <iframe
        class="w-full h-screen min-h-full shadow-md shadow-indigo-300 rounded"
        :srcdoc="email.body"
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
