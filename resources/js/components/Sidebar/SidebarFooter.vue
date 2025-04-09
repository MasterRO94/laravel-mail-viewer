<template>
  <footer class="flex flex-col p-2 border-t border-gray-200 dark:border-slate-700">
    <div class="flex items-center text-xs text-center text-slate-700 dark:text-gray-200">
      <input
        id="auto-update-input"
        v-model="autoUpdateEnabled"
        type="checkbox"
        class="
        text-teal-600 bg-gray-100 border-gray-300 rounded-sm
        focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2
        dark:bg-gray-700 dark:border-gray-600
        "
      >

      <label
        for="auto-update-input"
        class="ms-2 text-sm font-medium"
      >
        Auto load new entries
      </label>
    </div>
  </footer>
</template>

<script
  setup
  lang="ts"
>
import { computed } from 'vue';
import store from '@/store';

const autoUpdateEnabled = computed({
  get() {
    return store.autoUpdateEnabled;
  },

  set(value: boolean) {
    store.autoUpdateEnabled = value;
  }
});

</script>
