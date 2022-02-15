<template>
  <section
    role="preview"
    class="w-3/4 px-3"
  >
    <Header :email="email" />

    <tabs
      :options="{useUrlFragment: false}"
      nav-class="flex pl-6 space-x-3"
      nav-item-class="px-3 py-2 border border-b-0 border-solid border-indigo-200 rounded-t text-slate-500 bg-gray-200 transition"
      nav-item-active-class="bg-gray-100 border-indigo-300 text-slate-900 font-bold scale-y-110 transition"
      panels-wrapper-class="w-full p-2 border shadow shadow-indigo-200 border-solid border-indigo-200 rounded bg-gray-100"
    >
      <PreviewTab :email="email" />
      <HtmlTab :email="email" />
      <HeadersTab :email="email" />
      <BodyTab :email="email" />
    </tabs>
  </section>
</template>

<script>
import BodyTab from './Preview/BodyTab';
import Header from './Preview/Header';
import HeadersTab from './Preview/HeadersTab';
import HtmlTab from './Preview/HtmlTab';
import PreviewTab from './Preview/PreviewTab';

export default {
  components: { BodyTab, HeadersTab, HtmlTab, Header, PreviewTab },
  props: {
    email: {
      type: Object,
      required: true,
    },
  },
};
</script>
