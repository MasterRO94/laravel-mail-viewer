<template>
  <div class="container font-primary">
    <Header />

    <Mails />

    <Footer />
  </div>
</template>

<script>
import { ref } from 'vue';
import Footer from './Footer';
import Header from './Header';
import Mails from './Mails';

export default {
  name: 'App',

  components: { Mails, Footer, Header },

  setup() {
    const counter = ref(0);

    const increment = () => counter.value++;

    return {
      increment,
      counter,
      greeting: 'Hello World from Vue 3!',
    };
  },
};
</script>
