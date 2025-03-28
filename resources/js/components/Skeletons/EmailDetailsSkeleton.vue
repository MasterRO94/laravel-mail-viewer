<template>
  <div
    class="flex flex-col justify-center mt-8"
  >
    <div class="w-80 h-8 bg-slate-300 dark:bg-slate-600/70 rounded-md animate-pulse" />

    <div class="flex flex-col gap-2 mt-4">
      <div
        v-for="i in count"
        :key="`email-list-skeleton-item-${i}`"
        class="flex gap-2"
      >
        <div
          class="h-5 bg-slate-300 dark:bg-slate-600/70 rounded-md animate-pulse"
          :class="{
            'w-12': i % 2 == 0,
            'w-18': i % 2 != 0,
          }"
        />

        <div class="w-72 h-5 bg-slate-200 dark:bg-slate-800 rounded-md animate-pulse" />
      </div>
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
const { count = 2 } = defineProps<{
  count?: number,
}>();
</script>
