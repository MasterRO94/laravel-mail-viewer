<template>
  <Tab name="Payload">
    <div class="p-3 bg-gray-200 rounded-sm min-h-screen">
      <div
        v-show="!payload[email.id]"
        class="p-2 mt-4"
      >
        <button
          class="
            block mx-auto p-1.5 px-3 rounded-md border-0 text-indigo-400 outline-indigo-400 outline outline-offset-0 outline-2
            focus:outline-indigo-600 focus:bg-indigo-500 focus:outline-offset-0 focus:outline-2 focus:text-white
            hover:outline-indigo-500 hover:text-white hover:bg-indigo-400
          "
          :disabled="loading"
          v-text="loading ? 'Loading...' : 'Load Email Payload'"
          @click="loadPayload"
        />
      </div>
      <pre
        v-show="payload[email.id]"
        v-text="payload[email.id]"
        class="text-slate-800 overflow-auto"
      />
    </div>
  </Tab>
</template>

<script>
import {
  reactive,
  ref,
} from 'vue';
import Api from '../../api/Api';

export default {
  props: {
    email: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const loading = ref(false);
    const payload = reactive({});

    const loadPayload = async () => {
      loading.value = true;
      payload[props.email.id] = await Api.fetchPayload(props.email);
      loading.value = false;
    };

    return {
      loading,
      loadPayload,
      payload,
    };
  },
};
</script>
