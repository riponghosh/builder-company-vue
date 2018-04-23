<template>
  <div>
    <nav-bar class="navbar"></nav-bar>
    <router-view class="content"></router-view>
  </div>
</template>

<script>
  import NavBar from './components/common/NavBar.vue'

  export default {
    components: {
      NavBar
    },
    data() {
      return {
        timer: null
      }
    },
    methods: {
      getFixed() {
        let nav = document.querySelector('.navbar')
        if (document.body.offsetWidth <= 1200) {
          let top = window.pageYOffset
          let width = document.body.scrollWidth
          nav.style.top = top + 'px'
          nav.style.width = width + 'px'
        } else {
          nav.style.top = '0px'
          nav.style.width = '100%'
        }        
      },
      getFixedThrottle() {
        clearInterval(this.timer)
        this.timer = setTimeout(this.getFixed.bind(this), 50)
      }
    },
    created() {
      window.addEventListener('scroll', this.getFixedThrottle)
      window.addEventListener('resize', this.getFixedThrottle)
    },
    destroyed() {
      window.removeEventListener('scroll', this.getFixedThrottle)
      window.removeEventListener('resize', this.getFixedThrottle)
    }
  }
</script>

<style lang="scss">
  @font-face {
    font-family: 'Roboto';
    font-style: normal;
    src: local('Roboto Regular'), local('Roboto-Regular'),
      url(http://themes.googleusercontent.com/static/fonts/roboto/v9/abcd.woff)
        format('woff');
  }

  html,
  body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
  }

  .navbar {
    z-index: 1024;
    position: fixed;
    top: 0px;
    left: 0;
    width: 100%;
    height: 60px;
    overflow: auto;
  }

  .content {
    margin-top: 60px;
  }

  @media screen and (max-width: 1200px) {
    .navbar {
      position: absolute;
      top: 0;
      left: 0;
    }
  }
</style>
