<template>
  <el-container>
    <el-aside width="20vw" style="min-width: 200px;">
      <side-bar class="sidebar"></side-bar>
    </el-aside>
    <el-main>
      <router-view></router-view>
    </el-main>
  </el-container>
</template>

<script>
  import FooterBar from '../common/FooterBar.vue'
  import SideBar from './SideBar.vue'

  export default {
    components: {
      FooterBar,
      SideBar,
    },
    mounted() {

    },
  }
</script>

<style lang="scss" scoped>
  @import "../../assets/styles/base.scss";

  .sidebar {
    z-index: 1024;
    position: fixed;
    top: 60px;
    bottom: 0px;
    width: 20vw;
    min-width: 200px;
    height: calc(100% - 60px);
    overflow: auto;
  }
</style>
