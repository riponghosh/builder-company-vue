<template>
  <div>
    <el-rate v-model="numberValue"></el-rate>
  </div>
</template>

<script>
  export default {
    props: ['value'],
    computed: {
      numberValue: {
        get() {
          return parseInt(this.value, 10)
        },
        set(value) {
        }
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import "../../assets/styles/base";

  .el-rate {
    padding: 4px;
    height: auto;
    display: flex;
    justify-content: space-around;
    /deep/ .el-rate__icon {
      margin: 0 4px 10px;
      font-size: 1.5rem;
    }
  }

  .el-rate /deep/ .el-rate__icon {
    &::before {
      color: $white;
    }
    &.el-icon-star-on::before {
      content: '\E637';
      color: $white;
    }
  }
</style>
