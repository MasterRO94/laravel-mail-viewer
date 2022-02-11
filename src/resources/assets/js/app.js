import { createApp } from 'vue';
import {Tabs, Tab} from 'vue3-tabs-component';
import App from './components/App.vue';

window.VueApp = createApp(App);
window.VueApp
  .component('tabs', Tabs)
  .component('tab', Tab)
  .mount('#app');
