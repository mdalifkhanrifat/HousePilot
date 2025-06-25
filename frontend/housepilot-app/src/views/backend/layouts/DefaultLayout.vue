<template>
  <div>
    <Header />
    <div class="flex">
      <Sidebar />
      <main class="flex-1">
        <slot />
      </main>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from '../components/Header.vue';
import Sidebar from '../components/Sidebar.vue';
import Footer from '../components/Footer.vue';

export default {
  components: {
    Header,
    Sidebar,
    Footer
  }
}
</script>