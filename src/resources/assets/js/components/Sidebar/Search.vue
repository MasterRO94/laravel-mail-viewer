<template>
  <section class="flex justify-between">
    <div class="p-2 pl-1 w-full relative group">
      <input
        type="text"
        name="search"
        v-model="search"
        @input="onInput"
        placeholder="Search..."
        class="
          w-full rounded-md border-0 outline-indigo-400 outline outline-offset-0 outline-2
          focus:outline-indigo-600 focus:outline-offset-0 focus:outline-2
          hover:outline-indigo-500
        "
      >
      <span
        v-show="search"
        class="
          absolute top-[0.7rem] right-4 text-indigo-600 font-bold text-2xl cursor-pointer
          hidden group-hover:block hover:opacity-90
        "
        @click="clearSearch"
      >
        &times;
      </span>
    </div>

    <!--    <div class="p-2 pr-1">-->
    <!--      <button-->
    <!--        class="-->
    <!--          w-full p-1.5 rounded-md border-0 text-indigo-400 outline-indigo-400 outline outline-offset-0 outline-2-->
    <!--          focus:outline-indigo-600 focus:bg-indigo-500 focus:outline-offset-0 focus:outline-2 focus:text-white-->
    <!--          hover:outline-indigo-500 hover:text-white hover:bg-indigo-400-->
    <!--        "-->
    <!--      >-->
    <!--        <svg-->
    <!--          xmlns="http://www.w3.org/2000/svg"-->
    <!--          fill="none"-->
    <!--          viewBox="0 0 24 24"-->
    <!--          stroke="currentColor"-->
    <!--          class="h-7 w-7"-->
    <!--        >-->
    <!--          <path-->
    <!--            stroke-linecap="round"-->
    <!--            stroke-linejoin="round"-->
    <!--            stroke-width="2"-->
    <!--            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"-->
    <!--          />-->
    <!--        </svg>-->
    <!--      </button>-->
    <!--    </div>-->
  </section>
</template>

<script setup>
import debounce from 'lodash/debounce';
import {
  defineEmits,
  ref,
} from 'vue';

const search = ref('');
const emit = defineEmits(['search']);

const onInput = debounce(() => {
  emit('search', search.value);
}, 500);

const clearSearch = () => {
  if (!search.value) {
    return;
  }

  search.value = '';
  emit('search', search.value);
};
</script>
