<template>
  <div class="container font-primary">
    <Header />
    <Main />
  </div>
</template>

<script>
import Header from './Layout/Header.vue';
import Main from './Layout/Main.vue';

export default {
  name: 'App',

  components: {
    Main,
    Header,
  },
};
</script>
