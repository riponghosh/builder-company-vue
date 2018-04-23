<template>
  <el-menu :default-active="$router.currentRoute.query.category || this.$store.getters.defaultCategory.value" mode="horizontal" @select="handleSelect" class="category">
    <el-menu-item v-for="i in $store.state.config.category" :index="i.value" :key="i.value" class="item">
      {{ i.label }}

    </el-menu-item>
  </el-menu>
</template>

<script>
  export default {
    mounted() {
    },
    data() {
      return {}
    },
    methods: {
      handleSelect(key) {
        const currentRoute = this.$router.currentRoute
        const query = Object.assign({}, currentRoute.query)
        query.category = key
        this.$router.replace({
          path: currentRoute.path,
          query,
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../assets/styles/base.scss";

  .category {
    background: $ultramarine;
    border: none;
    text-align: center;
    .item {
      color: $white;
      float: none;
      display: inline-block;
      position: relative;
      z-index: 10;
    }
    /deep/ .el-menu-item.is-active {
      color: white;
      &::before {
        content: '';
        position: absolute;
        top: 43px;
        left: 10%;
        width: 80%;
        z-index: -10;
        height: 5px;
        background: $yellow;
      }
    }
  }

  // .el-menu--horizontal > .el-menu-item.is-active {
  //   border-bottom: 2px solid $white;
  // }
  .el-menu-item:hover, .el-menu-item:focus {
    background: none;
    color: #ccc;
  }
</style>
