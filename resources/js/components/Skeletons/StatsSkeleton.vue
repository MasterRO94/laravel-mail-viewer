<template>
  <div
    class="flex items-center justify-start gap-4"
  >
    <div
      v-for="i in count"
      :key="`stat-skeleton-item-${i}`"
      class="flex flex-col items-center justify-center gap-2 px-2 py-3 bg-slate-200 dark:bg-slate-800 rounded-sm animate-pulse"
    >
      <div class="w-8 h-5 rounded-md bg-slate-300 dark:bg-slate-600/70" />

      <div class="w-20 h-3.5 rounded-md bg-slate-300 dark:bg-slate-600/50" />
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
const { count = 6 } = defineProps<{
  count?: number,
}>();
</script>
