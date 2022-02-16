<template>
  <header class="flex justify-between w-full bg-indigo-500 p-5 rounded-b-md">
    <div class="flex text-white">
      <span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="h-12 w-12"
        >
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
          <polyline points="22,6 12,13 2,6"></polyline>
        </svg>
      </span>

      <p class="text-3xl px-3 pt-[0.5rem]">
        Outbound Emails - <small v-text="appName" />
      </p>
    </div>

    <div class="text-white text-2xl">
      <strong>
        Stats
      </strong>
    </div>
  </header>
</template>

<script setup>
const appName = document.querySelector('#app').dataset.appName;
</script>