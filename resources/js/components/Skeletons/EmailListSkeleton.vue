<template>
  <div class="flex flex-col divide-y divide-gray-200 dark:divide-slate-700">
    <div
      v-for="i in count"
      :key="`skeleton-item-${i}`"
      class="flex justify-between px-2 py-3 animate-pulse"
    >
      <div class="flex flex-col gap-2">
        <div
          class="w-62 rounded-md h-4 bg-slate-300 dark:bg-slate-600/70"
        />

        <div class="flex gap-4">
          <div class="w-28 rounded-md h-3.5 bg-slate-300 dark:bg-slate-600/50" />
          <div class="w-24 rounded-md h-3.5 bg-slate-300 dark:bg-slate-600/50" />
        </div>
      </div>

      <div class="flex flex-col gap-2">
        <div class="w-16 rounded-md h-3 bg-slate-300 dark:bg-slate-600/50" />
        <div class="w-14 rounded-md h-3 bg-slate-300 dark:bg-slate-600/50" />
      </div>
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
const { count = 10 } = defineProps<{
  count?: number,
}>();
</script>
