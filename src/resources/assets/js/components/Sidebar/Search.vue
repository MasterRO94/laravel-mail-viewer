<template>
  <section>
    <div class="flex justify-between">
      <div
        class="p-1 w-full relative group"
        :class="showFilter ? 'mb-2' : 'mb-4'"
      >
        <input
          type="text"
          name="search"
          v-model="search"
          @input="onInput"
          placeholder="Search..."
          class="
            w-full rounded-md border-0 outline-indigo-400 outline outline-offset-0 outline-2
            focus:outline-indigo-600 focus:outline-offset-0 focus:outline-2
            hover:outline-indigo-500 text-slate-600
          "
        >
        <span
          v-show="search"
          class="
          absolute top-2 right-4 text-indigo-600 font-bold text-2xl cursor-pointer
          hidden group-hover:block hover:opacity-70 transition
        "
          @click="clearSearch"
        >
          &times;
        </span>
      </div>

      <div class="p-1 pl-2">
        <button
          class="
            w-full p-2.5 rounded-md border-0 outline-offset-0 outline outline-2
            hover:outline-indigo-500 hover:text-white hover:bg-indigo-400
          "
          :class="showFilter
            ? 'outline-indigo-600 bg-indigo-500 outline-offset-0 outline-2 text-white'
            : 'outline-indigo-400 text-indigo-400'
          "
          @click="toggleFilter"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </div>

    <Transition name="ease-out">
      <form
        v-show="showFilter"
        action="#"
        target="_self"
        @submit.prevent="filter"
        class="mb-4 py-1 -mx-2 flex group"
      >
        <div class="flex flex-col w-1/2 px-3">
          <label
            for="filter_date_from"
            class="text-sm text-slate-600"
          >
            Date From
          </label>

          <input
            type="date"
            v-model="filters.dateFrom"
            placeholder="Date From"
            id="filter_date_from"
            name="date_from"
            class="
              rounded-md border-0 outline-indigo-400 outline outline-offset-0 outline-2
              focus:outline-indigo-600 focus:outline-offset-0 focus:outline-2
              hover:outline-indigo-500 text-slate-700
            "
            @change="filter"
          >
        </div>

        <div class="flex flex-col w-1/2 px-3">
          <label
            for="filter_date_to"
            class="text-sm text-slate-600"
          >
            Date To
          </label>

          <input
            type="date"
            v-model="filters.dateTo"
            placeholder="Date To"
            id="filter_date_to"
            name="date_to"
            class="
              rounded-md border-0 outline-indigo-400 outline outline-offset-0 outline-2
              focus:outline-indigo-600 focus:outline-offset-0 focus:outline-2
              hover:outline-indigo-500 text-slate-700
            "
            @change="filter"
          >
        </div>
      </form>
    </Transition>
  </section>
</template>

<script setup>
import debounce from 'lodash/debounce';
import {
  defineEmits,
  reactive,
  ref,
} from 'vue';

const search = ref('');
const showFilter = ref(false);
const filters = reactive({
  dateFrom: '',
  dateTo: '',
});

const emit = defineEmits(['search', 'filter']);

const onInput = debounce(() => {
  emit('search', search.value);
}, 500);

const toggleFilter = () => {
  showFilter.value = !showFilter.value;
};

const filter = () => {
  emit('filter', filters);
};

const clearSearch = () => {
  if (!search.value) {
    return;
  }

  search.value = '';
  emit('search', search.value);
};
</script>
