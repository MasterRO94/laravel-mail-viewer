<template>
  <section class="w-full p-2 pb-4">
    <form
      action="#"
      class="max-w-md mx-auto"
    >
      <label
        for="search-input"
        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
      >
        Search
      </label>

      <div class="flex justify-between items-center gap-2">
        <div class="relative w-full group">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <IconSearch class="size-4 text-gray-500 dark:text-gray-400" />
          </div>

          <input
            id="search-input"
            ref="searchInput"
            v-model="searchTerm"
            v-debounce:input.400="() => onInput()"
            type="text"
            class="
              block w-full ps-9 text-gray-900 border border-gray-300 rounded-md bg-gray-50 peer
              focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600
              dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-600 dark:focus:border-teal-600
            "
            placeholder="Search Emails..."
            required
          />

          <span
            class="
              absolute top-2 right-3 inline-flex items-center gap-1 text-slate-700 dark:text-gray-400 rounded-sm px-1 transition-colors
              border border-slate-400 dark:border-gray-400 peer-focus:invisible
            "
            @click="focusSearchInput"
          >
            <kbd
              v-if="isMac"
              class=""
            >
              ⌘
            </kbd>
            <kbd
              v-else
              class="Ctrl"
            >
              ⌘
            </kbd>

            <kbd class="inline-block text-sm pb-0.5">
              K
            </kbd>
          </span>

          <span
            v-show="searchTerm"
            class="
              absolute top-1 right-3 text-teal-600 font-bold text-2xl cursor-pointer
              hidden group-hover:block hover:opacity-70 transition
            "
            @click="clearSearch"
          >
            &times;
          </span>
        </div>

        <div>
          <Btn @click="showDateFilter = !showDateFilter">
            <IconFilterFilled />
          </Btn>
        </div>
      </div>

      <Transition
        enter-active-class="ease-out duration-150"
        enter-from-class="opacity-0 scale-90"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="ease-in duration-150"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-90"
      >
        <div
          v-show="showDateFilter"
          class="flex items-center py-2"
          :class="{
            'animate-fade-in-scale': showDateFilter,
            'animate-fade-out-scale': !showDateFilter,
          }"
        >
          <Datepicker
            id="start-date-input"
            v-model="startDate"
            placeholder="Start Date"
            @input="onInput"
          />

          <span class="mx-2 text-gray-500">-</span>

          <Datepicker
            id="end-date-input"
            v-model="endDate"
            placeholder="End Date"
            @input="onInput"
          />
        </div>
      </Transition>
    </form>
  </section>
</template>

<script
  setup
  lang="ts"
>
import { onBeforeUnmount, onMounted, ref, useTemplateRef } from 'vue';
import { IconFilterFilled, IconSearch } from '@tabler/icons-vue';
import getUserOS from '@/helpers';
import Btn from '@/components/Common/Btn.vue';
import Datepicker from '@/components/Common/Datepicker.vue';

const emit = defineEmits(['filter']);

const searchTerm = ref<string>('');
const showDateFilter = ref<boolean>(false);
const startDate = ref<Date | null>(null);
const endDate = ref<Date | null>(null);

const searchInput = useTemplateRef('searchInput');

const formatDate = (date: Date | null) => {
  if (!date) {
    return null;
  }

  const year = String(date.getFullYear());
  const month = date.getMonth() > 8 ? String(date.getMonth() + 1) : `0${String(date.getMonth() + 1)}`;
  const day = date.getDate() > 9 ? String(date.getDate()) : `0${String(date.getDate())}`;

  return `${year}-${month}-${day}`;
};

const onInput = () => {
  emit('filter', {
    search: searchTerm.value,
    startDate: formatDate(startDate.value),
    endDate: formatDate(endDate.value),
  });
};

const clearSearch = () => {
  searchTerm.value = '';

  onInput();
};

const isMac = getUserOS() === 'MacOS';

const focusSearchInput = () => {
  searchInput.value?.focus();
};

const handleSearchShortcut = (event: KeyboardEvent) => {
  const { key, ctrlKey, metaKey } = event;

  if (key !== 'k') {
    return;
  }

  if ((isMac && metaKey) || (!isMac && ctrlKey)) {
    focusSearchInput();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleSearchShortcut);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleSearchShortcut);
});
</script>
