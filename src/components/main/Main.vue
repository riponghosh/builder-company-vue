<template>
  <div>
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
    <!-- <footer-bar></footer-bar> -->
  </div>
</template>

<script>
  import FooterBar from '../common/FooterBar.vue'

  export default {
    components: {
      FooterBar,
    }
  }
</script>

