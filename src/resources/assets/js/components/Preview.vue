<template>
  <section
    role="preview"
    class="w-3/4 px-3"
  >
    <section class="mb-4">
      <div
        class="text-2xl text-gray-700"
        v-text="email.subject"
      />

      <div
        class=""
      >
        <strong>
          From:
        </strong>
        <span
          class="text-gray-700"
          v-html="email.formattedFrom"
        />
      </div>

      <div
        v-for="(recipient, key) of {to: email.formattedTo, cc: email.formattedCc, bcc: email.formattedBcc}"
        :key="`currentEmail-${email.id}-${key}`"
        v-show="recipient"
      >
        <strong
          class="capitalize"
          v-text="`${key}:`"
        />
        &nbsp;
        <span
          class="text-gray-700"
          v-html="recipient"
        />
      </div>
    </section>

    <tabs
      :options="{useUrlFragment: false}"
      nav-class="flex pl-6 space-x-3"
      nav-item-class="px-3 py-2 border border-b-0 border-solid border-indigo-200 rounded-t text-slate-500 bg-gray-200 transition"
      nav-item-active-class="bg-gray-100 border-indigo-300 text-slate-900 font-bold scale-y-110 transition"
      panels-wrapper-class="w-full p-2 border shadow shadow-indigo-200 border-solid border-indigo-200 rounded bg-gray-100"
    >
      <tab name="Preview">
        <div class="w-full">
          <iframe
            class="w-full h-screen min-h-full shadow-md shadow-indigo-300 rounded"
            :srcdoc="email.body"
          />
        </div>
      </tab>

      <tab name="Headers">
        <div class="p-3 bg-gray-200 space-y-2 rounded">
          <p
            v-for="(header, i) in email.headers"
            :key="`email-${email.id}-header-${i}`"
            v-text="header"
            class="text-slate-800"
          />
        </div>
      </tab>

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

      <tab name="Body">
        <div class="p-3 bg-gray-200 rounded min-h-screen">
          <pre
            v-text="email.payload"
            class="text-slate-800 overflow-auto"
          />
        </div>
      </tab>
    </tabs>
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
