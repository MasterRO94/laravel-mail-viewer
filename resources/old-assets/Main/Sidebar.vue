<template>
  <aside class="w-1/4 overflow-y-auto h-screen sticky top-1 pr-2">
    <Search
      @search="onSearch"
      @filter="onFilter"
    />

    <section class="relative">
      <div
        v-if="loading"
        class="mb-4 mt-5 p-5 absolute w-full z-10"
      >
        <div class="flex items-center justify-center ">
          <div class="w-24 h-24 border-l-2 border-indigo-600 rounded-full animate-spin"></div>
        </div>
      </div>

      <div
        v-show="loading"
        class="absolute top-0 w-full h-full bg-white bg-opacity-50"
      />

      <div class="space-y-1">
        <div
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
          <Subject :email="email" />

          <Recipients
            :email="email"
            :is-active="currentEmail?.id === email.id"
          />
        </div>
      </div>
    </section>

    <div
      v-show="hasMorePages"
      class="p-2 mt-2"
    >
      <button
        class="
          w-full p-1.5 rounded-md border-0 text-indigo-400 outline-indigo-400 outline outline-offset-0 outline-2
          focus:outline-indigo-600 focus:bg-indigo-500 focus:outline-offset-0 focus:outline-2 focus:text-white
          hover:outline-indigo-500 hover:text-white hover:bg-indigo-400
        "
        :disabled="loading"
        v-text="loading ? 'Loading...' : 'Load More'"
        @click="loadMore"
      />
    </div>
  </aside>
</template>

<script>
import Recipients from '../Sidebar/Recipients.vue';
import Search from '../Sidebar/Search.vue';
import Subject from '../Sidebar/Subject.vue';

export default {
  components: { Search, Recipients, Subject },

  props: {
    loading: {
      type: Boolean,
      required: false,
      default: true,
    },

    hasMorePages: {
      type: Boolean,
      required: false,
      default: false,
    },

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

    const onSearch = (term) => {
      ctx.emit('search', term);
    };

    const onFilter = (filters) => {
      ctx.emit('filter', filters);
    };

    const loadMore = () => {
      ctx.emit('loadMore');
    };

    return {
      show,
      onSearch,
      onFilter,
      loadMore,
    };
  },
};
</script>
