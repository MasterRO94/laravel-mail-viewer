<template>
  <main class="flex mt-3">
    <Sidebar
      :emails="data.emails"
      :current-email="data.currentEmail"
      :loading="loading"
      :has-more-pages="data.hasMorePages"
      @show="show"
      @search="onSearch"
      @filter="onFilter"
      @loadMore="loadMore"
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
  ref,
} from 'vue';
import Api from '../../api/Api';
import Preview from '../Mails/Preview';
import Sidebar from '../Mails/Sidebar';

export default {
  components: { Preview, Sidebar },

  setup() {
    const loading = ref(true);
    const search = ref('');
    const filters = ref({});

    const data = reactive({
      emails: [],
      currentEmail: null,
      page: 1,
      hasMorePages: false,
    });

    const loadEmails = async (params = {}, merge = false) => {
      loading.value = true;

      params.search = search.value;
      Object.entries(filters.value).forEach(([key, value]) => params[key] = value);

      const response = await Api.fetchMails(params);

      if (response) {
        data.page = response.data['current_page'];
        data.emails = merge ? [...data.emails, ...response.data.data] : response.data.data;
        data.hasMorePages = response.data['last_page'] > data.page;
        data.currentEmail = data.currentEmail && data.emails.find((email) => email.id === data.currentEmail.id)
          ? data.currentEmail
          : data.emails?.[0];

        loading.value = false;
      }
    };

    onMounted(async () => {
      await loadEmails();
    });

    const show = (email) => {
      data.currentEmail = email;
    };

    const onSearch = async (term) => {
      if (term === '') {
        search.value = term;

        await loadEmails();
        return;
      }

      if (String(term).trim().length < 2) {
        return;
      }

      search.value = term;

      await loadEmails();
    };

    const onFilter = async (params) => {
      filters.value = params;
      await loadEmails();
    };

    const loadMore = async () => {
      await loadEmails({ page: data.page + 1 }, true);
    };

    return {
      loading,
      data,
      show,
      onSearch,
      onFilter,
      loadMore,
    };
  },
};
</script>
