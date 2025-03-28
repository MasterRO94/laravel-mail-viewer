<template>
  <section
    role="preview"
    class="w-3/4 px-3"
  >
    <Header :email="email" />

    <Tabs
      :options="{useUrlFragment: false}"
      nav-class="flex pl-6 space-x-3"
      nav-item-class="px-3 py-2 border border-b-0 border-solid border-indigo-200 rounded-t text-slate-500 bg-gray-200 transition"
      nav-item-active-class="bg-gray-100 border-indigo-300 text-slate-900 font-bold scale-y-110 transition"
      panels-wrapper-class="w-full p-2 border shadow-sm shadow-indigo-200 border-solid border-indigo-200 rounded-sm bg-gray-100"
    >
      <PreviewTab :email="email" />
      <HtmlTab :email="email" />
      <HeadersTab :email="email" />
      <PayloadTab :email="email" />
    </Tabs>
  </section>
</template>

<script>
import PayloadTab from '../Preview/PayloadTab.vue';
import Header from '../Preview/Header.vue';
import HeadersTab from '../Preview/HeadersTab.vue';
import HtmlTab from '../Preview/HtmlTab.vue';
import PreviewTab from '../Preview/PreviewTab.vue';

export default {
  components: { PayloadTab, HeadersTab, HtmlTab, Header, PreviewTab },
  props: {
    email: {
      type: Object,
      required: true,
    },
  },
};
</script>
