<template>
  <section
    v-if="!loading"
    class="flex items-center gap-4"
  >
    <Metric
      v-for="metric of stats?.data"
      :key="metric.key"
      :metric
    />
  </section>

  <StatsSkeleton v-else />
</template>

<script
  setup
  lang="ts"
>
import { onBeforeMount, ref } from 'vue';
import { fetchStats } from '@/api/stats';
import { ModelCollection } from '@/types';
import MetricModel from '@/models/Metric';
import Metric from './Metric.vue';
import StatsSkeleton from '@/components/Skeletons/StatsSkeleton.vue';

const stats = ref<ModelCollection<MetricModel> | null>(null);

const loading = ref<boolean>(false);

onBeforeMount(async () => {
  loading.value = true;

  stats.value = await fetchStats();

  loading.value = false;
});
</script>
