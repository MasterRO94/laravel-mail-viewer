<template>
  <main
    class="px-5 py-2 w-full text-gray-700 dark:text-gray-200 overflow-x-hidden"
  >
    <Stats />

    <EmailDetails
      v-if="email"
      :email
    />

    <EmailDetailsSkeleton
      v-else-if="!initialized"
      class="flex flex-col justify-center mt-8"
    />

    <div
      v-else
      class="flex justify-start mt-8"
    >
      Emails preview and their details will appear here.
    </div>

    <section
      v-if="email"
      class="mt-5 p-2 bg-slate-100 dark:bg-slate-800 rounded-sm"
    >
      <div class="flex border-b-2 border-b-gray-200 dark:border-b-slate-700">
        <div
          v-for="(title, key) in tabs"
          v-show="shouldDisplayTab(key)"
          :key="`tab-${key}`"
          v-tw-merge
          class="
            flex gap-2 py-2 px-8 border-b-2 border-b-transparent cursor-pointer -mb-[2px] transition-all
            hover:border-b-teal-500/60
          "
          :class="{ 'font-bold border-b-teal-500 hover:border-b-teal-500': activeTab === key }"
          @click="selectTab(key)"
        >
          <span v-html="title" />

          <span
            v-if="key === 'attachments'"
            class="
              inline-flex w-[25px] justify-center items-center aspect-square
              text-white bg-teal-500 dark:bg-teal-700 rounded-full
            "
            v-text="email.attachments.length ?? ''"
          />
        </div>
      </div>

      <div
        class="mt-2 p-2"
      >
        <PreviewTab
          v-show="activeTab === 'preview'"
          :active="activeTab === 'preview'"
          :email
        />

        <HtmlSourceTab
          v-show="activeTab === 'html'"
          :active="activeTab === 'html'"
          :email
        />

        <TextTab
          v-show="activeTab === 'text'"
          :active="activeTab === 'text'"
          :email
        />

        <HeadersTab
          v-show="activeTab === 'headers'"
          :active="activeTab === 'headers'"
          :email
        />

        <AttachmentsTab
          v-show="activeTab === 'attachments'"
          :active="activeTab === 'attachments'"
          :email
        />

        <PayloadTab
          v-show="activeTab === 'payload'"
          :active="activeTab === 'payload'"
          :email
        />
      </div>
    </section>
  </main>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import Stats from '@/components/Common/Stats.vue';
import EmailDetails from '@/components/Main/EmailDetails.vue';
import { computed, ref, watch } from 'vue';
import PreviewTab from './PreviewTab.vue';
import HtmlSourceTab from '@/components/Main/HtmlSourceTab.vue';
import HeadersTab from './HeadersTab.vue';
import PayloadTab from './PayloadTab.vue';
import TextTab from './TextTab.vue';
import AttachmentsTab from '@/components/Main/AttachmentsTab.vue';
import EmailDetailsSkeleton from '@/components/Skeletons/EmailDetailsSkeleton.vue';
import store from '@/store';

const { email } = defineProps({
  email: {
    type: [Email, null],
    required: true,
  },
});

const tabs = {
  preview: 'Preview',
  html: 'HTML Source',
  text: 'Text',
  headers: 'Headers',
  attachments: `Attachments`,
  payload: 'Raw Payload',
};

export type TabName = keyof typeof tabs;

const activeTab = ref<TabName>('preview');
const initialized = computed(() => store.initialized);

const selectTab = (tab: TabName) => {
  if (tab === 'payload' && email?.attachments.length) {
    window.open(
      `${window.location.origin}${window.location.pathname}/emails/${String(email.id)}/raw-payload`,
      '_blank',
    );

    return;
  }

  activeTab.value = tab;
};

const shouldDisplayTab = (tab: TabName): boolean => {
  if (tab === 'text') {
    return Boolean(email?.text);
  }

  if (tab === 'attachments') {
    return email?.attachments.length as number > 0;
  }

  return true;
};

watch(() => email, () => {
  selectTab('preview');
});
</script>
