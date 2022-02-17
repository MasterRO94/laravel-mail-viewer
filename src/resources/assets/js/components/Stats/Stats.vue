<template>
  <section class="text-slate-200 flex flex-wrap">
    <div class="w-full">
      Sent emails:
    </div>

    <div class="flex space-x-3">
      <div
        v-for="(value, key) of stats"
        :key="`stats-${key}`"
        class="flex justify-between"
      >
        <span v-text="key" />:&nbsp;
        <strong v-text="value" />
      </div>
    </div>
  </section>
</template>

<script>
import {
  onMounted,
  reactive,
} from 'vue';
import Api from '../../api/Api';

export default {
  setup() {
    const stats = reactive({});

    onMounted(async () => {
      const response = await Api.fetchStats();
      Object.entries(response.data).forEach(([key, value]) => stats[key] = value);
    });

    return {
      stats,
    };
  },
};
</script>
