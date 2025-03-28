<template>
  <div
    class="flex flex-col gap-2 p-2 bg-slate-200 dark:bg-slate-800 rounded-sm"
  >
    <div class="text-center">
      <strong v-text="metric.value" />
    </div>

    <p
      class="text-xs"
      v-text="metric.title"
    />
  </div>
</template>

<script
  setup
  lang="ts"
>
import Metric from '@/models/Metric';

defineProps({
  metric: {
    type: Metric,
    required: true,
  }
});
</script>
