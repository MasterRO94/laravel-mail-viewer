<template>
  <div class="container font-primary">
    <Header />

    <Mails />

    <Footer />
  </div>
</template>

<script>
import Footer from './Layout/Footer';
import Header from './Layout/Header';
import Mails from './Layout/Mails';

export default {
  name: 'App',

  components: { Mails, Footer, Header },
};
</script>
