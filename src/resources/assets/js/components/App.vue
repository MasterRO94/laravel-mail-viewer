<template>
  <div class="container font-primary">
    <Header />
    <Main />
  </div>
</template>

<script>
import Header from './Layout/Header';
import Main from './Layout/Main';

export default {
  name: 'App',

  components: { Main, Header },
};
</script>
