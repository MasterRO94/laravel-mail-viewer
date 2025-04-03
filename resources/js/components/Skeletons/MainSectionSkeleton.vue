<template>
  <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-sm">
    <div class="flex gap-4">
      <div
        v-for="i in count"
        :key="`tab-skeleton-${i}`"
        class="w-42 max-w-1/5 h-8 bg-slate-300 dark:bg-slate-600/70 rounded-md animate-pulse"
      />
    </div>

    <div
      class="mt-1 w-full h-0.5 bg-slate-300 dark:bg-slate-600/70 rounded-md animate-pulse"
    />

    <div
      class="mt-4 flex flex-col justify-center items-center gap-2 animate-pulse"
    >
      <div class="flex flex-col gap-2 w-[600px] max-w-full">
        <div class="h-4 bg-slate-300 dark:bg-slate-600/70 rounded-md w-64 mb-2" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[430px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[450px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[420px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[380px]" />
      </div>

      <div
        class="flex items-center justify-center w-[600px] max-w-full h-48 bg-slate-300 dark:bg-slate-600/70 rounded-md"
      >
        <svg
          class="w-10 h-10 text-gray-200 dark:text-gray-600"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 20 18"
        >
          <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
        </svg>
      </div>

      <div class="flex flex-col gap-2 w-[600px] max-w-full">
        <div class="h-4 bg-slate-300 dark:bg-slate-600/70 rounded-md w-64 mb-2" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[440px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[480px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[460px]" />
        <div class="h-2 bg-slate-300 dark:bg-slate-600/70 rounded-md max-w-[360px]" />
      </div>

      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
const { count = 5 } = defineProps<{
  count?: number,
}>();
</script>
