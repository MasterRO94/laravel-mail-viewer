import { createApp } from 'vue';
import App from './components/App.vue';
import TwMerge from '@/directives/TwMerge';
import Visibility from '@/directives/Visibility';

const app = createApp(App);

app.directive('tw-merge', TwMerge);
app.directive('visibility', Visibility);
app.mount('#app');
