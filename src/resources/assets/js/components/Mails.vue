<template>
  <main class="flex mt-3">
    <Sidebar
      :emails="data.emails"
      :current-email="data.currentEmail"
      @show="show"
    />

    <Preview
      v-if="data.currentEmail"
      :email="data.currentEmail"
    />
  </main>
</template>

<script>
import {
  onMounted,
  reactive,
} from 'vue';
import Api from '../api/Api';
import Preview from './Preview';
import Sidebar from './Sidebar';

export default {
  components: { Preview, Sidebar },
  setup() {
    const data = reactive({
      emails: [],
      currentEmail: null,
    });

    onMounted(async () => {
      const response = await Api.fetchMails();
      data.page = response.data['current_page'];
      data.emails = response.data.data;
      data.hasMorePages = response.data['last_page'] > data.page;
      data.currentEmail = data.emails?.[0];
    });

    const show = (email) => {
      data.currentEmail = email;
    };

    return {
      data,
      show,
    };
  },
};
</script>
