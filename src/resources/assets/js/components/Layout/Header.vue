<template>
  <header class="flex justify-between w-full bg-indigo-500 p-5 rounded-b-md">
    <div>
      <a
        :href="appUrl"
        title="Home page"
        class="flex text-white"
      >
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
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
            <polyline points="22,6 12,13 2,6" />
          </svg>
        </span>

        <span class="text-3xl px-3 pt-[0.5rem]">
          Outbound Emails - <small v-text="appName" />
        </span>
      </a>
    </div>

    <Stats />
  </header>
</template>

<script setup>
import Stats from '../Stats/Stats';

const appName = document.querySelector('#app').dataset.appName;
const appUrl = document.querySelector('#app').dataset.appUrl;
</script>
