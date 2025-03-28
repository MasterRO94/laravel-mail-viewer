<template>
  <button
    v-if="!href"
    v-tw-merge
    class="
      w-full inline-flex gap-1 cursor-pointer rounded-md bg-teal-500 dark:bg-teal-700 p-2 text-white transition-colors
      hover:bg-teal-500/80 active:bg-teal-500/70 dark:hover:bg-teal-700/80 dark:active:bg-teal-700/70
    "
    :type
  >
    <slot>
      {{ text }}
    </slot>
  </button>

  <a
    v-else
    v-tw-merge
    class="
      w-full inline-flex gap-1 cursor-pointer rounded-md bg-teal-500 dark:bg-teal-700 p-2 text-white transition-colors
      hover:bg-teal-500/80 active:bg-teal-500/70 dark:hover:bg-teal-700/80 dark:active:bg-teal-700/70
    "
    :href
  >
    <slot>
      {{ text }}
    </slot>
  </a>
</template>

<script
  setup
  lang="ts"
>
const { type = 'button' } = defineProps<{
  text?: string;
  type?: 'button' | 'submit';
  href?: string;
}>();
</script>
