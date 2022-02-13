<template>
  <aside class="flex-col space-y-2 w-1/4 overflow-y-auto h-screen sticky top-1">
    <section
      v-for="email of emails"
      :key="`email-${email.id}`"
      class="
          flex-col group p-2 transition cursor-pointer rounded shadow shadow-indigo-200
          hover:text-white hover:bg-indigo-300 hover:pl-[8px] hover:border-b-indigo-300 hover:border-l-4 hover:border-indigo-500
        "
      :class="
          currentEmail?.id === email.id
            ? 'text-slate-100 bg-indigo-400 pl-[8px] border-b-indigo-300 border-l-4 border-indigo-500 is-active'
            :'pl-[12px] bg-sky-100  text-gray-700 border-b border-solid border-indigo-300'
        "
      @click="show(email)"
    >
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

      <div class="flex justify-between">
        <div
          class="text-xs max-w-sm group-hover:text-white"
          :class="currentEmail?.id === email.id ? 'text-white' : 'text-slate-500'"
        >
          <div
            v-for="(recipient, key) of {to: email.formattedTo}"
            :key="`email-${email.id}-${key}`"
            v-show="recipient"
          >
            <strong
              class="capitalize"
              v-text="`${key}:`"
            />
            &nbsp;
            <span
              v-html="recipient"
            />
          </div>
        </div>
      </div>
    </section>
  </aside>
</template>

<script>
export default {
  props:{
    emails: {
      type: Array,
      required: false,
      default: [],
    },
    currentEmail: {
      type: Object,
      required: false,
      default: () => null,
    },
  },

  setup(props, ctx) {

    const show = (email) => {
      ctx.emit('show', email);
    };

    return {
      show,
    };
  },
};
</script>
