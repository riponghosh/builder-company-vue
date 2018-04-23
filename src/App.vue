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

