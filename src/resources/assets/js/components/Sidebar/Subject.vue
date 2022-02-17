<template>
  <div class="flex justify-between">
    <div
      class=""
      v-text="email.subject"
    />

    <div class="text-right text-sm ml-2">
      <div
        class="pt-[0.2rem]"
        v-text="email.formattedDate"
      />
      <div
        v-text="email.formattedTime"
      />
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
  },
};
</script>
