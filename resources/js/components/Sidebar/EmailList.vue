<template>
  <div class="relative">
    <EmailListSkeleton v-if="loading && !initialized" />

    <div
      v-else-if="emails?.data.length > 0"
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

    <div
      v-if="emails && initialized"
      v-show="emails.last_page > emails.current_page"
      class="mt-4"
    >
      <button
        v-show="!loading"
        v-visibility.visible="() => loadEmails(emails.current_page + 1)"
        class="
          w-full rounded-md bg-teal-500 p-2 text-white transition-colors
          hover:bg-teal-500/80 active:bg-teal-500/70 cursor-pointer
        "
        @click="loadEmails(emails.current_page + 1)"
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
import { computed, onBeforeMount, ref } from 'vue';
import store from '@/store';
import { fetchEmails } from '@/api';
import { ModelCollectionWithPagination } from '@/types';
import Email from '@/models/Email';
import EmailListItem from './EmailListItem.vue';
import EmailListSkeleton from '@/components/Skeletons/EmailListSkeleton.vue';
import Loader from '@/components/Common/Loader.vue';

const emit = defineEmits<{
  selected: [email: Email],
}>();

const activeEmail = ref<Email | null>(null);

const initialized = computed(() => store.initialized);
const loading = ref<boolean>(false);
const emails = ref<ModelCollectionWithPagination<Email> | null>(null);

const loadEmails = async (page: number = 1) => {
  if (loading.value) {
    return;
  }

  if (emails.value && (emails.value.current_page === page || emails.value.last_page < page)) {
    return;
  }

  loading.value = true;

  const data = await fetchEmails({ page });

  if (emails.value?.data.length) {
    data.data = [
      ...emails.value.data,
      ...data.data,
    ];
  }

  emails.value = data;

  if (!activeEmail.value && emails.value.data.length) {
    select(emails.value.data[0]);
  }

  store.initialized = true;
  loading.value = false;
};

const select = (email: Email) => {
  activeEmail.value = email;
  emit('selected', email);
};

onBeforeMount(loadEmails);
</script>
