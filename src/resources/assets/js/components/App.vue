<template>
  <div class="container font-primary">
    <Header />

    <Mails />

    <Footer />
  </div>
</template>

<script>
import Footer from './Footer';
import Header from './Header';
import Mails from './Mails';

export default {
  name: 'App',

  components: { Mails, Footer, Header },
};
</script>
