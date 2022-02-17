import 'highlight.js/styles/atom-one-dark.css';
import { createApp } from 'vue';
import VueHighlightJS from 'vue3-highlightjs';
import { Tab,Tabs } from 'vue3-tabs-component';
import App from './components/App.vue';

window.VueApp = createApp(App);
window.VueApp
  .use(VueHighlightJS)
  .component('Tabs', Tabs)
  .component('Tab', Tab)
  .mount('#app');
