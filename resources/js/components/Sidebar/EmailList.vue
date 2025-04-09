<template>
  <EmailListSkeleton v-if="loading && !initialized" />

  <Filter
    v-else-if="initialized"
    @filter="search"
  />

  <div class="flex flex-1 flex-col gap-2 min-h-0 overflow-auto">
    <div class="relative">
      <Loader
        v-show="loading"
        class="absolute z-10 top-5 w-full"
      />

      <div
        v-if="emails?.data?.length"
        class="
         divide-y divide-gray-200 dark:divide-slate-700
        "
      >
        <EmailListItem
          v-for="email in emails.data"
          :key="`email-${email.id}`"
          :email
          :active="activeEmail?.id === email.id"
          @selected="select(email)"
        />
      </div>
    </div>

    <div
      v-if="emails?.data?.length"
      v-show="emails.hasMoreItems"
      class="mt-4"
    >
      <button
        v-show="!loading"
        v-visibility.visible="() => loadEmails(false)"
        class="
          w-full rounded-md bg-teal-500 p-2 text-white transition-colors
          hover:bg-teal-500/80 active:bg-teal-500/70 cursor-pointer
        "
        @click="loadEmails(false)"
      >
        Load more
      </button>

      <Loader v-show="loading" />
    </div>

    <div
      v-if="!emails?.data.length && initialized"
      class="flex justify-center items-center w-full mt-2 p-2 text-slate-700 dark:text-gray-200"
    >
      <p>No emails sent yet.</p>
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import { computed, onBeforeMount, onMounted, reactive, ref, watch } from 'vue';
import store from '@/store';
import { fetchEmails } from '@/api';
import { EmailRequestParams, ModelCollectionWithPagination } from '@/types';
import Email from '@/models/Email';
import EmailListItem from './EmailListItem.vue';
import EmailListSkeleton from '@/components/Skeletons/EmailListSkeleton.vue';
import Loader from '@/components/Common/Loader.vue';
import Filter from '@/components/Sidebar/Filter.vue';

const activeEmail = computed({
  get(): Email | null {
    return store.activeEmail;
  },

  set(value: Email | null) {
    store.activeEmail = value;
  }
});

const initialized = computed(() => store.initialized);

const autoUpdateEnabled = computed(() => store.autoUpdateEnabled);
let autoUpdateInterval: number;

const loading = ref<boolean>(false);
const searching = ref<boolean>(false);

const emails = ref<ModelCollectionWithPagination<Email> | null>(null);

const filter = reactive<{
  search: string;
  startDate: string;
  endDate: string;
}>({
  search: '',
  startDate: '',
  endDate: '',
});

const loadEmails = async (fetchNew: boolean = false, merge: boolean = true) => {
  if (loading.value && !fetchNew) {
    return;
  }

  if (emails.value && !emails.value.hasMoreItems && !fetchNew) {
    return;
  }

  if (!fetchNew) {
    loading.value = true;
  }

  const params: EmailRequestParams = { ...filter };

  if (fetchNew) {
    if (!emails.value?.data[0].id) {
      return;
    }

    params.latestId = emails.value.data[0].id;
  } else {
    const oldestId = emails.value?.data[emails.value.data.length - 1].id;

    if (oldestId) {
      params.oldestId = oldestId;
    }
  }

  const data = await fetchEmails(params);

  if (merge) {
    data.data = fetchNew ? [
      ...data.data.map(email => email.markAsNew()),
      ...emails.value?.data ?? [],
    ] : [
      ...emails.value?.data ?? [],
      ...data.data,
    ];
  }

  if (fetchNew && emails.value?.data.length) {
    emails.value.data = data.data;
  } else {
    emails.value = data;
  }

  if ((!activeEmail.value && emails.value.data.length) || emails.value.data.length === 1) {
    select(emails.value.data[0]);
  }

  store.initialized = true;
  loading.value = false;
};

const select = (email: Email) => {
  activeEmail.value = email;
};

const handleAutoUpdate = () => {
  if (!autoUpdateEnabled.value) {
    clearInterval(autoUpdateInterval);

    return;
  }

  autoUpdateInterval = setInterval(async () => {
    if (!initialized.value) {
      return;
    }

    if (!autoUpdateEnabled.value) {
      clearInterval(autoUpdateInterval);

      return;
    }

    await loadEmails(true, true);
  }, 4444);
};

const search = async (filters: { search: string, startDate: string | null, endDate: string | null }) => {
  searching.value = true;
  filter.search = filters.search;
  filter.startDate = filters.startDate ?? '';
  filter.endDate = filters.endDate ?? '';

  await loadEmails(false, false);

  searching.value = false;
};

onBeforeMount(loadEmails);
onMounted(handleAutoUpdate);

watch(() => autoUpdateEnabled.value, handleAutoUpdate);
</script>
