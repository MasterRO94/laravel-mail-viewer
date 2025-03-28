<template>
  <Tab name="Preview">
    <section class="w-full">
      <div class="w-full">
        <iframe
          class="w-full h-screen min-h-full shadow-md shadow-indigo-300 rounded-sm"
          :srcdoc="email.body"
        />
      </div>

      <div
        v-if="attachments.length"
        class="flex flex-wrap p-2 pt-1 mt-3"
      >
        <div
          v-for="(attachment, i) of attachments"
          :key="`email-${email.id}-attachment-${i}`"
          class="flex border-solid border border-indigo-600 rounded-md text-white bg-indigo-400 py-1.5 pl-2 pr-3 mt-1 mr-1"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            class="h-6 w-6 mr-1"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
            />
          </svg>
          <span v-text="attachment.name" />
        </div>
      </div>
    </section>
  </Tab>
</template>

<script>
import {
  ref,
  watch,
} from 'vue';

export default {
  props: {
    email: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const attachments = ref(Object.values(props.email.attachments).filter(a => a.name));

    watch(props, (prop) => {
      attachments.value = Object.values(prop.email.attachments).filter(a => a.name);
    });

    return {
      attachments,
    };
  },
};
</script>
